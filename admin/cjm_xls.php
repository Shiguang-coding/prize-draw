<?php 
include('../core.php');
if (!S('islogin')) str_alert('','login.php'); 
sys_xls(time().'.xls');
?>


<table border="1">
			  
              <tr>
                 
				<td width="50" class="list" style="padding:0px; text-align:center;">ID</td>
                <td class="list" width="120" >抽奖码</td>
				<td class="list" width="150" >指定奖项</td>
                <td class="list" width="200" >生成时间</td>
                <td class="list" width="80" >状态</td> 
				 
              </tr>
			  <?php 
              $w['order']      = 'a.id desc'; 
			  $w['a.no']         = I('keyword'); 
			  $w['select']     = 'a.*,b.name as award_name'; 
			  $w['join'][C('PREFIX').'award as b'] = 'a.award_id=b.id'; 
			  
			  $l = D('cjm as a',$w);
			  foreach($l as $k=>$v) {
			  ?>
              <tr class="mouse click">
				 <td class="list-text"><?php echo $v['id']?></td>
				 <td class="list-text"><?php echo $v['no']?></td>
				 <td class="list-text"><?php echo $v['award_name']?></td>
				 <td class="list-text"><?php echo $v['addtime']?></td>
	             <td class="list-text"><?php echo $v['state']==1? '已使用':'未使用'?></td> 
				 
              </tr>
			  <?php }?>           
   	   
		  
</table>
