<?php 
 $invoiceno='1234';
 $invoicefor='Jhone Doe';
 $invoiceforaddress='123 california CA 12345 USA';
 $contact='(800)2745994';
 $invoicedate='19-03-21';
 $duedate='19-03-21';
 $email='invoice@legologix.com';
 $company='Legologix LLC';
 $address='55 Madison avenue Suite 400 Morristown NJ07960';
 $subtotal='$4000';
 $previousbalance='$2000';
 $total='$6000';
 function fetch_data()  
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "testing");  
      $sql = "SELECT * FROM invoice ORDER BY id ASC";  
      $result = mysqli_query($connect, $sql);  
      while($row = mysqli_fetch_array($result))  
      {       
      $output .= '<tr>  
                          <td style="color:#411CBA;text-align:center;font-weight:bolder;">'.$row["consult_name"].'</td>  
                          <td style="text-align:center;">'.$row["start_date"].' '.$row["end_date"].'</td>  
                          <td style="text-align:center;">'.$row["hours_wrkd"].'</td>  
                          <td style="text-align:center;">'.$row["rate"].'</td>  
						  <td style="text-align:center;">$'.$row["total"].'</td>  
                     </tr>';  
      }  
      return $output;  
 }  
 if(isset($_POST["create_pdf"]))  
 {  
      require_once('tcpdf/tcpdf.php');  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      //$obj_pdf->addTTFfont('FontAwesome.ttf', 'TrueTypeUnicode','', 32);
	$obj_pdf->SetFont('helvetica', '', 12); 	  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= ' 
		<style>
		table, tr, td{
		border-collapse: collapse;
		padding: 2px;
		font-size:95%;
		}
	tr.border_bottom th{
	font-weight:bold;
	border-bottom: 1px solid #411CBA;
	
	}
	
	.headlogo{
		border-bottom: 1px solid darkgrey;
	}
	h4{
		border-bottom: 1px solid #411CBA;
		border-top: 1px solid #411CBA;
		display:inline-block;
		//width:auto;
		//margin: auto;
		//padding: 0 20px 5px; 
	}
		table.datatbl,tr{
		padding: 5px;
	}
	
	</style>
	<table>
	<tbody class="headlogo">
	<tr>
	<td align="center" class="headlogo"><img src="lego-logo.png" style="height:40px;width:120px"/></td>
	</tr>
	</tbody>
	</table>
	<br/>
	<h2 align="left" style="color:#411CBA;">Invoice</h2><i class="fa fa-envelope fa-11px"></i>
	<table>
	<tbody>
	<tr>
	
	<td width="35%"><strong style="color:#152238;">Invoice : </strong>'.$invoiceno.'</td>
	<td width="40%"align="middle" ><strong style="color:#152238;">Invoice for : </strong>'.$invoicefor.'</td>
	<td width="30%"><img src="phone_l.png" style="height:5px;width:10px;color:#152238;"/>  <span>'.$contact.'</span></td>
	</tr>
	<tr>
	<td><strong style="color:#152238;">Invoice Date : </strong>'.$invoicedate.'</td>
	<td align="middle" rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.wordwrap($invoiceforaddress,20,"<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",TRUE).'</td>
	<td ><img src="email_l.png" style="height:5px;width:10px"/> <span>'.$email.'</span></td>
	</tr>
	<tr>
	<td rowspan="2"><strong style="color:#152238;">Due Date : </strong>'.$duedate.'</td>
	<td><img src="location_l.png" style="height:5px;width:10px"/> <span>'.$company.'</span></td>
	</tr>
	<tr>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<span>'.wordwrap($address,20,"<br/>&nbsp;&nbsp;&nbsp;&nbsp;",True).'</span></td>
	</tr>
	</tbody>
	</table>
	<br/><br/><br/>';
	$content .='<table class="datatbl">
		
           <tr class="border_bottom">  
                <th style="text-align:center;" width="25%">Consultant</th>  
                <th style="text-align:center;"width="20%">Period</th> 
                <th style="text-align:center;"width="20%">Hours Worked</th>  				
                <th style="text-align:center;"width="15%">Rate</th>  
                <th style="text-align:center;"width="20%">Total Due</th>  
           </tr> 
		   
		   
	';  
      $content .= fetch_data(); 
	$content .='<tr><td colspan="5"></td></tr>
	 <tr>
	<td colspan="5" align="right"><strong style="color:#152238;">Sub Total: '.$subtotal.'</strong></td>
	</tr>
	<tr>
	<td colspan="3"></td>
	<td colspan="2" align="right" border="1"><strong style="color:#152238;">Previous Balance: '.$previousbalance.'</strong><h4 style="color:#411CBA;">Total: '.$total.'</h4></td>
	</tr>
	<tr>
	<td></td>
	</tr>
	<tr>
	<td colspan="4" align="center"><strong>Note:</strong> Thankyou for using legologix for your Training and development Needs</td>
	</tr>
	
	';
      $content .= '</table>'; 
	  
	 $obj_pdf->writeHTML($content);
	  
      $obj_pdf->Output('sample.pdf', 'I'); 
	  
	  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Invoice</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />            
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:700px;">  
                <h3 align="center">Invoice</h3><br />  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="5%">ID</th>  
                               <th width="30%">Consultant Name</th>  
                               <th width="10%">Period</th>  
                               <th width="45%">Rate</th>  
                               <th width="10%">Total Due</th>  
                          </tr>  
                     <?php  
                     echo fetch_data();  
                     ?>  
                     </table>  
                     <br />  
                     <form method="post">  
                          <input type="submit" name="create_pdf" class="btn btn-danger" value="Draft(PDF)" />  
                     </form>  
                </div>  
           </div>  
      </body>  
	  </html>