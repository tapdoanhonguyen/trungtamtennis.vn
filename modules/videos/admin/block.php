<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */
if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$page_title = $lang_module['block'];

$sql = 'SELECT bid, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
$result = $db->query($sql);

$array_block = array();
while (list ($bid_i, $title_i) = $result->fetch(3)) {
    $array_block[$bid_i] = $title_i;
}
if (empty($array_block)) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=groups');
}

$cookie_bid = $nv_Request->get_int('int_bid', 'cookie', 0);
if (empty($cookie_bid) or ! isset($array_block[$cookie_bid])) {
    $cookie_bid = 0;
}

$bid = $nv_Request->get_int('bid', 'get,post', $cookie_bid);
if (! in_array($bid, array_keys($array_block))) {
    $bid_array_id = array_keys($array_block);
    $bid = $bid_array_id[0];
}

if ($cookie_bid != $bid) {
    $nv_Request->set_Cookie('int_bid', $bid, NV_LIVE_COOKIE_TIME);
}
$page_title = $array_block[$bid];

if ($nv_Request->isset_request('checkss,idcheck', 'post') and $nv_Request->get_string('checkss', 'post') == md5(session_id())) {
    $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE bid=' . $bid;
    $result = $db->query($sql);
    $_id_array_exit = array();
    while (list ($_id) = $result->fetch(3)) {
        $_id_array_exit[] = $_id;
    }
    
    $id_array = array_map('intval', $nv_Request->get_array('idcheck', 'post'));
    foreach ($id_array as $id) {
        if (! in_array($id, $_id_array_exit)) {
            try {
                $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_block (bid, id, weight) VALUES (' . $bid . ', ' . $id . ', 0)');
            } catch (PDOException $e) {
                trigger_error($e->getMessage());
            }
        }
    }
    nv_videos_fix_block($bid);
    $nv_Cache->delMod($module_name);
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&bid=' . $bid);
    die();
}

$select_options = array();
foreach ($array_block as $xbid => $blockname) {
    $select_options[NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;bid=' . $xbid] = $blockname;
}

$xtpl = new XTemplate('block.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$listid = $nv_Request->get_string('listid', 'get', '');
if ($listid == '' and $bid) {
    $xtpl->assign('BLOCK_LIST', nv_show_block_list($bid));
} else {
    $page_title = $lang_module['addtoblock'];
    $id_array = array_map('intval', explode(',', $listid));
    
    $db->sqlreset()
        ->select('id, title')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_rows')
        ->order('publtime DESC')
        ->where('status=1 AND id IN (' . implode(',', $id_array) . ')');
    
    $result = $db->query($db->sql());
    
    while (list ($id, $title) = $result->fetch(3)) {
        $xtpl->assign('ROW', array(
            'checked' => in_array($id, $id_array) ? ' checked="checked"' : '',
            'title' => $title,
            'id' => $id
        ));
        
        $xtpl->parse('main.news.loop');
    }
    
    foreach ($array_block as $xbid => $blockname) {
        $xtpl->assign('BID', array(
            'key' => $xbid,
            'title' => $blockname,
            'selected' => $xbid == $bid ? ' selected="selected"' : ''
        ));
        $xtpl->parse('main.news.bid');
    }
    
    $xtpl->assign('CHECKSESS', md5(session_id()));
    $xtpl->parse('main.news');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$set_active_op = 'groups';
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';