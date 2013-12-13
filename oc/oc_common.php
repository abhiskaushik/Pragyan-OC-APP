<?php
if(!defined('__PRAGYAN_CMS'))
{ 
	header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
	echo "<h1>403 Forbidden<h1><h4>You are not authorized to access the page.</h4>";
	echo '<hr/>'.$_SERVER['SERVER_SIGNATURE'];
	exit(1);
}

/**
 * @package pragyan
 * @copyright (c) 2012 Pragyan Team
 * @author shriram<vshriram93@gmail.com>
 * @license http://www.gnu.org/licenses/ GNU Public License
 * For more details, see README
 */

function displayOCDownload() {
  global $sourceFolder,$moduleFolder;
  require_once($sourceFolder."/".$moduleFolder."/qaos1/excel.php");
  $table=<<<TABLE
    <table>
      <thead>
        <td width="1000px"><b>Name</b></td>
        <td width="1000px"><b>Email(Start Adding From row 2)</b></td>
      </thead>
    </table>





TABLE;
  displayExcelForTable($table);  
}

function view_registered_users($mcId) {
  global $STARTSCRIPTS;
  $smarttablestuff = smarttable::render(array('table_accousers'),null);                                                
  $STARTSCRIPTS .="initSmartTable();";                                                                                                 
  $userDetails =<<<TABLE
    $smarttablestuff
    <table class="display" id="table_accousers" width="100%" border="1">
      <thead>
        <tr>
          <th>Name</th>
          <th>E mail</th>
          <th>Roll No.</th>
          <th>Plan</th>
          <th>T-Shirt</th>
           </tr>
    </thead>

TABLE;
  $getRegisteredUserDetailQuery = "SELECT * FROM `oc_form_reg`";
  $getRegisteredUserOc = mysql_query($getRegisteredUserDetailQuery) or displayerror("Error on viewing registered user".mysql_error());
  while($res = mysql_fetch_assoc($getRegisteredUserOc)) {
    
    //$name = getUserName($res['name']);
    //$email = getUserEmail($res['user_id']);
    $userDetails .=<<<TR
      <tr>
        <td>{$res['name']}</td>
       <td>{$res['user_id']}</td>
       <td>{$res['user_id']}</td>
       <td>{$res['amount']}</td>
       <td>{$res['Tshirt_size']}</td>
       
       
       
      </tr>
TR;
  }
  $userDetails .=<<<TABLEEND
    </table>
TABLEEND;
  return $userDetails;
}

function view_whitelist_emails($mcId){
global $STARTSCRIPTS;
  $smarttablestuff = smarttable::render(array('table_accousers'),null);                                                
  $STARTSCRIPTS .="initSmartTable();";

    $userDetails =<<<TABLE
    $smarttablestuff
    <table class="display" id="table_accousers" width="100%" border="1">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Remove Email</th>
           </tr>
    </thead>

TABLE;
  $getRegisteredUserDetailQuery = "SELECT oc_name,oc_valid_email FROM `oc_valid_emails`";
  $getRegisteredUserOc = mysql_query($getRegisteredUserDetailQuery) or displayerror("Error on viewing registered user".mysql_error());
while($res = mysql_fetch_assoc($getRegisteredUserOc)) {
    
    //$name = getUserName($res['oc_name']);
    //$email = getUserEmail($res['oc_valid_email']);
      
    $userDetails .=<<<TR
 
      <tr>
        <td>{$res['oc_name']}</td>
       <td>{$res['oc_valid_email']}</td> 
       <td>
      <form method="POST" action="./+ochead&subaction=view_whitelist_users">
             <input type="hidden" name="removing" value="{$res['oc_valid_email']}" />
           <input type="submit" name="remove_email" value="REMOVE"/>
           
          </form> </td>
    
         
</tr>
 
       
      
TR;
  }

 $userDetails .=<<<TABLEEND
    </table>
TABLEEND;
/*
 $displayTags=<<<TAG
   <form method="get" action="./+ochead&subaction=view_whitelist_users">
     	<table>
         <tr> 
           <td><input type="submit" name='remove_email' value="Remove Marked Emails"></td>
           </tr>
        </table>
</form>                                    
TAG;
 */


if(isset($_POST['remove_email'])){
$removing_user=$_POST['removing'];
$query="DELETE * FROM `oc_valid_emails` WHERE `oc_valid_email`={$removing_user} ";
mysql_query($query);
//displayinfo($query);
  }

return $userDetails.$displayTags;

}
function add_whitelist_email($mcId){
$addWhiteList.=<<<FORM
             
          
            <form action="./+ochead&subaction=add_whitelist_email" method="post">
	      <input type="text" name="roll" autofocus required placeholder='Name' style='height:25px;width:200px;font-size:20px;'>
              <input type="text" name="email"  required placeholder='Email' style='height:25px;width:200px;font-size:20px;'>
<input type="submit" name="add_email" style="font-size:18px" value="Add This User">
</form>
   
FORM;
if(isset($_POST['add_email']))
{ $name=$_POST['roll']; $email=$_POST['email'];
$query=mysql_query("INSERT INTO `oc_valid_emails` (`page_modulecomponentid`,`oc_name`,`oc_valid_email`) VALUES ('$mcId','$name','$email')");
if($query)
displayinfo("Successfully Added");
else
displayinfo(mysql_error());


}
return $addWhiteList;
}
function availability($mcId){



}
function reg_status($mcId){

global $STARTSCRIPTS;
  $smarttablestuff = smarttable::render(array('table_accousers'),null);                                                
  $STARTSCRIPTS .="initSmartTable();";

    $userDetails =<<<TABLE
    $smarttablestuff
    <table class="display" id="table_accousers" width="100%" border="1">
      <thead>
        <tr>
          <th>Total No. Of Registrations</th>
          <th>Total No. Of 500 Plan</th>
          <th>Total No. Of 700 Plan</th>
           </tr>
    </thead>

TABLE;
  $getRegStatus700 = mysql_query("SELECT * FROM `oc_form_reg` WHERE `amount`='700'");
  $getRegStatus500 = mysql_query("SELECT * FROM `oc_form_reg` WHERE `amount`='500'");
  $totalReg=mysql_query("SELECT DISTINCT `user_id` FROM `oc_form_reg` ");
  $countReg=mysql_num_rows($totalReg); $countReg500=mysql_num_rows($getRegStatus500); $countReg700=mysql_num_rows($getRegStatus700);
   

   $userDetails .=<<<TR
 
      <tr>
          <td>{$countReg}</td>
        <td>{$countReg500}</td>
        <td>{$countReg700}</td>
       
    
         
</tr>
 
       
      
TR;
 

 $userDetails .=<<<TABLEEND
    </table>
TABLEEND;

return $userDetails;
}

function check_existing($mcId,$barCode_roll){
 $email = $barCode_roll.'@nitt.edu';
$query1=mysql_query("SELECT  * FROM `oc_valid_emails` WHERE `oc_valid_email`='{$email}'") or displayerror(mysql_error()) ;
//displayinfo($query2);	
$query2=mysql_query("SELECT `amount` FROM `oc_form_reg` WHERE `user_id`='{$email}'");
//displayinfo("SELECT `amount` FROM `oc_form_reg` WHERE `user_id`='{$email}'");	
if(mysql_num_rows($query1)){
$res=mysql_fetch_assoc($query2);
displayinfo("Good!".'&nbsp'.$barCode_roll.'&nbsp'."deserves It!");
displayinfo("Plan is ".'&nbsp'.$res['amount']);
}
else
displayinfo("This is not a valid!");
}
