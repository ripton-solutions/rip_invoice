<?php  

 $invoiceno='1111';
 $invoicefor='John Doe';
 $invoiceforaddress='123 california CA 12345 USA';
 $contact='(800) 482 0586';
 $invoicedate='19-03-21';
 $duedate='19-03-21';
 $email='accounts@mirror.com';
 $address='111 Town square place suite 1203 jersey city Nj07310';
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
      $output .= '<tr class="border_bottom">  
                          <td style="color:#152238;text-align:center;"width="25%">'.$row["consult_name"].'</td>  
                          <td style="text-align:center;"width="20%">'.$row["start_date"].' '.$row["end_date"].'</td>  
                          <td style="text-align:center;"width="23%">'.$row["hours_wrkd"].'</td>  
                          <td style="text-align:center;"width="12%">'.$row["rate"].'</td>  
						  <td style="text-align:center;"width="20%">$'.$row["total"].'</td>  
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
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$obj_pdf->SetMargins(0, 0, 0, true);
 
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 11);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= ' 
	<style>
		table, tr, td{
		border-collapse: collapse;
		padding: 2px;
		font-size:95%;
		}
		.headlogo{
			//border-bottom: 1px solid darkgrey;
			background-color:#000033;
		}
	</style>
	<table>
	<tbody class="headlogo">
	<tr>
	<td align="center" class="headlogo"><img src="mirroar.jpg" style="height:45	px;width:120px"/></td>
	</tr>
	</tbody>
	</table>
	<br/><br/><br/>
	<table style="padding: 1px 35px; width: 100%;">
	<tbody>
	<tr>
	<td colspan="3"><h1 style="color:#152238;align:left;">Invoice</h1></td>
	</tr>
	<tr>
	<td colspan="3"></td>
	</tr>
	<tr>
	<td><strong>Invoice : </strong>'.$invoiceno.'</td>
	<td align="middle"><strong>Invoice for : </strong>'.$invoicefor.'</td>
	<td align="justify"><img src="phone_m.png" style="height:5px;width:10px;color:#003366;"/>  <span>'.$contact.'</span></td>
	</tr>
	<tr>
	<td><strong>Invoice Date : </strong>'.$invoicedate.'</td>
	<td align="middle" rowspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.wordwrap($invoiceforaddress,20,"<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",TRUE).'</td>
	<td align="justify"><img src="email_m.png" style="height:5px;width:10px"/> <span>'.$email.'</span></td>
	</tr>
	<tr>
	<td><strong>Due Date : </strong>'.$duedate.' </td>
	<td align="justify"><img src="location_m.png" style="height:5px;width:10px"/> <span>'.wordwrap($address,25,"<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",True).'</span></td>
	</tr>
	</tbody>
	</table>
	<br/><br/><br/>';
		
	$obj_pdf->writeHTML( $content, 0, 100,1);
	$obj_pdf->SetXY(10, 69.5);
	$content ='<style>
	table, tr, td{
	font-size:97%;
	}
	tr.border_bottom th{
		font-weight:bold;
		border-bottom: 1px solid #152238;
	}
	tr.border_bottom td{
		border-bottom: 0.5px solid #e6e6ff;
	}
	.datatbl{
		padding: 10px 0px 10px 0px;
	}
	</style>
		<table class="datatbl" style="padding-left:5px;margin-left:100px; width: 90%;">
			<tr class="border_bottom" >  
                <th style="text-align:center;" width="25%">Consultant</th>  
                <th style="text-align:center;" width="20%">Period</th>
                <th style="text-align:center;" width="23%">Hours Worked</th>  
                <th style="text-align:center;" width="12%">Rate</th>  
                <th style="text-align:center;" width="20%">Total Due</th>  
           </tr>
		  ';  
      $content .= fetch_data(); 
	$content .='<tr><td colspan="5"></td></tr>
	 <tr>
	<td colspan="5" align="right" style="color:#152238;"><strong>Sub Total: '.$subtotal.'</strong><br/><strong>Previous Balance: '.$previousbalance.'</strong></td>
	</tr>
	<tr><td colspan="4"></td>
	<td style="padding-top:10px;border-bottom: 1px solid #152238;border-top: 1px solid #152238;text-align:right;valign:middle;"><strong style="color:#152238;">Total: '.$total.'</strong></td>
	</tr>';
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