<?php
/**
 * Created by PhpStorm.
 * User: feng
 * Date: 16/4/28
 * Time: 00:09
 */

include_once 'common.php';

/**
 * 提交反馈信息
 * @param $pdo
 * @return string
 */
function commit_feedback($content, $contact, $pdo) {
    // 判断传递参数是否为空
    if (empty($content) || empty($contact)) {
        $json['code'] = 0;
        $json['message'] = '提交反馈失败,参数错误';
        return json_encode($json);
    }

    // 插入反馈信息数据
    $sql = "INSERT INTO jf_feedback (contact, content) VALUES (\"$contact\",\"$content\")";

    if ($pdo->query($sql)) {
        $json['code'] = 1;
        $json['message'] = '提交反馈成功';
        return json_encode($json);
    } else {
        $json['code'] = 0;
        $json['message'] = '提交反馈失败,请联系管理员';
        return json_encode($json);
    }
}

$content = $_POST['content'];
$contact = $_POST['contact'];

$json = commit_feedback($content, $contact, $pdo);
exit($json);




