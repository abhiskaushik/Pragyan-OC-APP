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
 * @copyright (c) 2008 Pragyan Team
 * @license http://www.gnu.org/licenses/ GNU Public License
 * For more details, see README
 */
class oc implements module, fileuploadable	 {
  private $userId;
  private $moduleComponentId;
  
public function getHtml($gotuid, $gotmoduleComponentId, $gotaction) {
    $this->userId = $gotuid;
    $this->moduleComponentId = $gotmoduleComponentId;
    if ($gotaction == 'ochead')
      return $this->actionOchead();
    if ($gotaction == 'octeam')
      return $this->actionOcteam();
    if ($gotaction == 'view')
      return $this->actionView();
    else return $this->actionView();
  }

public function actionView() {

        global $urlRequestRoot, $moduleFolder, $cmsFolder,$templateFolder,$sourceFolder,$STARTSCRIPTS;
     // require_once($sourceFolder."/".$moduleFolder."/oc/oc_registration.js");
$mcId= $this->moduleComponentId;
   $userId = $this->userId;
   $email = getUserEmail($userId);
   $l_uid=strlen($email);
   $roll_registrant=substr($email,0,$l_uid-9);
   displayinfo('Welcome'.'&nbsp'.substr($email,0,$l_uid-9));  
$registerForm .=<<<FORM
         <form action="./+view" method="post">
        <h1 align='center' style='color:brown'><u>Registration Form</u></h2>
       <center>
        
         <label for='name' style='font-size:20px;font-weight:bold'>Name:</label>
	      <input type="Name" name="name_registrant" required autofocus placeholder="Enter Your Name"/ style='width:200px;height:24px;font-size:20px'>
            <label for='Amount Plan' style='font-size:20px;font-weight:bold'> Amount:</label>
              <input type='radio'  name='amount_plan' value='700' onclick="document.getElementById('display_sizeTshirt').style.display='block'">700 (Food coupon + Pragyan T.Shirt) 
       <input type='radio' name='amount_plan' value='500' onclick="document.getElementById('display_sizeTshirt').style.display='none' ">500 (only Food Coupon)
</br>
	  <div id='display_sizeTshirt' style='display:none;'> <label for='size' style='font-weight:bold;font-size:20px'>T-shirt Size: </label>
     <input type='radio' name='size_tshirt' value='large'>Large
    <input type='radio' name='size_tshirt' value='small'>Small
    <input type='radio' name='size_tshirt' value='medium'>Medium
    <input type='radio' name='size_tshirt' value='XL'>XL
</div> <br>
 <input type='submit' name='submit_reg_form' style='font-size:20px;z-index:2' Value='Register'>
      </center>
       </form>

FORM;
     
$name=$_POST['name_registrant']; $amount=$_POST['amount_plan'];
$tsize=$_POST['size_tshirt'];
if(isset($_POST['submit_reg_form']))
{  if(isset($_POST['amount_plan'])&&$_POST['amount_plan']=='500')
 $query="INSERT INTO `oc_form_reg` (`page_modulecomponentid`,`name`,`amount`,`user_id`,`Tshirt_size`) VALUES ('$mcId','$name','$amount','$email','$tsize')";
 else if(isset($_POST['amount_plan'])&& $_POST['amount_plan']=='700')
       if(isset($_POST['size_tshirt']))
 $query="INSERT INTO `oc_form_reg` (`page_modulecomponentid`,`name`,`amount`,`user_id`,`Tshirt_size`) VALUES ('$mcId','$name','$amount','$email','$tsize')";
  else displayinfo("What the Crap? Choose T.Shirt Size");
 //mysql_query($query);
//displayinfo($query);
if(mysql_query($query))
 displayinfo("Your registration is complete.");
else
 displayerror("There was some error in registration!");
 
}
 return $registerForm;
}

public function actionOcteam() {
global $urlRequestRoot, $moduleFolder, $cmsFolder,$templateFolder,$sourceFolder,$STARTSCRIPTS;
  $page_moduleComponentId=$this->moduleComponentId;
require_once($sourceFolder."/".$moduleFolder."/oc/oc_common.php");
   /*$userId = $this->userId;
   $email = getUserEmail($userId);
   $l_uid=strlen($email);
   displayinfo(substr($email,0,$l_uid-9));
*/

$ocDuty.=<<<FORM
             <center>
           <div id='ocRollScan' style='height:250px;width:400px;background:lightblue'>
           <h1><u>Pragyan-14 Tshirt & Coupons Distribution by OC</u></h3>
            <form action="./+octeam" method="post">
	      <input type="text" name="roll" autofocus maxlength=9 required placeholder='Enter Roll Number' style='height:20px;width:200px;font-size:20px;margin-top:80px'/></br></br></br>
<input type="submit" name="check_existing" style="font-size:18px" value="Check this Roll">
</form>

</div>
</center>	   
FORM;

if(isset($_POST['check_existing'])){
$roll=$_POST['roll'];
return $ocDuty.check_existing($moduleComponentId,$roll);



  }
return $ocDuty;
}
 
public function actionOchead() {
    $page_moduleComponentId=$this->moduleComponentId;
    $userId = $this->userId;
    global $urlRequestRoot, $moduleFolder, $cmsFolder,$templateFolder,$sourceFolder,$STARTSCRIPTS;
    require_once($sourceFolder."/upload.lib.php");
    require_once($sourceFolder."/".$moduleFolder."/qaos1/excel.php");
    require_once($sourceFolder."/".$moduleFolder."/oc/oc_common.php");
     if(isset($_POST['downloadFormatExcel'])) {
        displayOCDownload();
     }
    if(isset($_FILES['fileUploadField']['name'])) {
      $date = date_create();

      $timeStamp = date_timestamp_get($date);
      $tempVar=$sourceFolder."/uploads/temp/".$timeStamp.$_FILES['fileUploadField']['name'][0];
      move_uploaded_file($_FILES["fileUploadField"]["tmp_name"][0],$tempVar);
      $excelData = readExcelSheet($tempVar);
      $success = 1;
       for($i=2;$i<=count($excelData);$i++)  {
            $query="INSERT INTO `oc_valid_emails` (`page_moduleComponentId`,`oc_name`,`oc_valid_email`) VALUES($page_moduleComponentId,'{$excelData[$i][1]}','{$excelData[$i][2]}')";
        mysql_query($query);
       
       }
    }
   $retOcHead ="";
   $uploadValidEmail=getFileUploadForm($this->moduleComponentId,"oc",'./+ochead',UPLOAD_SIZE_LIMIT,1);echo '</br>';		 
$retOcHead .=<<<FORM
         <form action="./+ochead" method="post">
	      <input type="submit" name="downloadFormatExcel" value="Download Event Sample Format"/>
	   </form>
FORM;
	$retOcHead.=$uploadValidEmail;
    
 $displayTags=<<<TAG
	<table>
         <tr>
           <td><a href="./+ochead&subaction=view_whitelist_users"> <div>View Whitelist Registrants</div></a></td>
           <td><a href="./+ochead&subaction=view_registered_users"><div>Registred Users</div></a></td>
           <td><a href="./+ochead&subaction=add_whitelist_email"><div>Add Whitelist Email</div></a></td>
           <td><a href="./+ochead&subaction=availability"><div>Check Availability</div></a></td>
           <td><a href="./+ochead&subaction=reg_status"><div>Current Registration Status</div></a></td>
           
         </tr>
        </table>
                                    
TAG;
if(isset($_GET['subaction'])&&$_GET['subaction'] == 'view_registered_users')   {
 return $retOcHead.$displayTags.view_registered_users($moduleComponentId);
    }
if(isset($_GET['subaction'])&&$_GET['subaction']=='view_whitelist_users'){

return $retOcHead.$displayTags.view_whitelist_emails($moduleComponentId);

}
if(isset($_GET['subaction'])&&$_GET['subaction']=='add_whitelist_email'){

return $retOcHead.$displayTags.add_whitelist_email($moduleComponentId);
}
if(isset($_GET['subaction'])&&$_GET['subaction']=='availability'){

return $retOcHead.$displayTags.availability($moduleComponentId);
}

if(isset($_GET['subaction'])&&$_GET['subaction']=='reg_status'){

return $retOcHead.$displayTags.reg_status($moduleComponentId);
}

  
return $retOcHead.$displayTags;   
}

       public static function getFileAccessPermission($pageId,$moduleComponentId,$userId, $fileName) 
       	       {
			return getPermissions($userId, $pageId, "view");
	      	}

	 public static function getUploadableFileProperties(&$fileTypesArray,&$maxFileSizeInBytes) 
	 	{
			$fileTypesArray = array('jpg','jpeg','png','doc','pdf','gif','bmp','css','js','html','xml','ods','odt','oft','pps','ppt','tex','tiff','txt','chm','mp3','mp2','wave','wav','mpg','ogg','mpeg','wmv','wma','wmf','rm','avi','gzip','gz','rar','bmp','psd','bz2','tar','zip','swf','fla','flv','eps','xcf','xls','exe','7z');
		     	$maxFileSizeInBytes = 30*1024*1024;
		}

public function deleteModule($moduleComponentId) {
  
  return true;
  }
  public function createModule($moduleComponentId) {
    ///No initialization
  }
  public function copyModule($moduleComponentId, $newId) {
    return true;
  }
}

