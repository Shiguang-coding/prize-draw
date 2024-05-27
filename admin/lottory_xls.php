<?php 
include('../core.php');
if (!S('islogin')) str_alert('','login.php'); 
sys_xls(time().'.xls');
?>


<table border="1">
			  
              <tr>
                 
				<td width="50" class="list" style="padding:0px; text-align:center;">ID</td>
                <td class="list" width="150" align="center">奖项</td>
				<td class="list" width="80" >抽奖码</td> 
				<td class="list" width="100" align="center">姓名</td>
				<td class="list" width="150"align="center">手机</td>
				<td class="list" width="450"align="center">寄送地址</td>
				<td class="list" width="150"align="center">抽奖时间</td>
				 
				<td class="list" width="80" align="center">状态</td>
				 
              </tr>
			  <?php 
              $w['order']      = 'id desc'; 
			  $w['_string']    = I('keyword')?' and (name like "%'.I('keyword').'%" or tel like "%'.I('keyword').'%" or award_name like "%'.I('keyword').'%")':'';   
			  $l = D('lottory',$w);
			  foreach($l as $k=>$v) {
			  ?>
              <tr class="mouse click">
				 
				<td class="list-text"><?php echo $v['id']?></td>
				 
				<td class="list-text"><?php echo $v['award_name']?></td>
				<td class="list-text"><?php echo $v['cjm']?></td>
				<td class="list-text"><?php echo $v['name']?></td>
				<td class="list-text"><?php echo $v['tel']?></td>
				<td class="list-text"><?php echo $v['address']?></td>
				<td class="list-text"><?php echo $v['addtime']?></td>
				 
				 
				<td class="list-text"><?php echo $v['state']==1?'已核销':'未核销'?></td>
				 
              </tr>
			  <?php }?>           
   	   
		  
</table>
