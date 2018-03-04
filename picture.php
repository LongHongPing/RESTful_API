<?php
/*
 * 修改用户头像
 * ajax验证
 * 返回json
 */
public function changeuserpic(){
    $msg = array();
    $path = $_SERVER['DOCUMENT_ROOT'].'/Public/UserPic/';  //图片上传保存绝对路径
    $showPath = '';  //图片显示路径
    if(isset($_FILES['Filedata'])){
//若上传错误，弹出错误ID
       if($_FILES['Filedata']['error'] > 0){
           $resultcode = 0;
           $resultmsg = '错误代码:'.$_FILES['Filedata']['error'];
       }
       elseif ($_FILES['Filedata']['size'] > 2*1024*1024){
           $resultcode = 1;
           $resultmsg = '上传图片不要大于2M';
       }
       else{
           $division = pathinfo($_FILES['Filedata']['name']);
           $extensionName = $division['extension'];  //获取文件扩展名
 //上传不是图片则不保存
           if(!in_array($extensionName,array('jpg','gif','png','jpeg'))){
               $resultcode = 2;
               $resultmsg = '错误，只可以上传图片';
           }
           else{
 //保存图片
               $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
               for($i = 0 ; $i < 10 ; $i++ ){
                   $key.= $pattern{mt_rand(0,35)};
               }
               $newFileName = sha1(date('Y-m-d',time()).$key).'.'.$extensionName;
               $savePath = $path.$newFileName;  //存储路径
               $showPath = 'Public/UserPic/'.$newFileName;
               move_uploaded_file($_FILES['Filedata']['tmp_name'],$savePath);
               if(!file_exists($savePath)){
                   $resultcode = 3;
                   $resultmsg = '上传失败';
               }
               else{
//添加图片路径到数据库
                   $userApi = new GglUserApi;
                   $icon_url = $userApi->getUserIconUrl();
                   $res = $userApi->changeIconPath($showPath);
                      if($res){
                          $resultcode = 4;
                          $resultmsg = '上传成功';
//删除原有图片
                          if(!empty($icon_url)){
                              unlink($_SERVER['DOCUMENT_ROOT'].$icon_url);
                          }
                          }
                          else{
                              $resultcode = 6;
                              $resultmsg = '图片保存失败';
                          unlink($savePath);
                          }
                      }
               }
           }
       }
       else{
           $resultcode = 5;
           $resultmsg = '文件未上传';
        }
    echo json_encode(array(
        '' => $resultcode,
        'msg' => $resultmsg,
        'path' => $showPath )
        );
}
?>