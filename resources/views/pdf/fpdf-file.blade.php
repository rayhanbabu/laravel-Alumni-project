@include('pdf/fpdf182/fpdf')
<?php

  
class PDF extends FPDF
{
function Header()
{
	
}	
   function Footer()
   {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',12);
        // Page number
        $this->Cell(0,10,date('d-M-Y, h:i:sA').  ',Developed by ancovabd.com ',0,0,'L');
        $this->Cell(0,10,date('d-M-Y, h:i:sA').  ', Developed by ancovabd.com',0,0,'R'); 
    }
		
}	
				
   
			
       $pdf= new PDF('L','mm','A4');
       $pdf->AliasNbPages();     
       $pdf->AddPage();

         // foreach($invoice as $row){

                    $pdf->SetFont('Times','I','20'); 						  
					$pdf->Cell(190,5,' ',0,1 , 'C' );  
                   
					$pdf->SetFont('Times','I','15');
					
					
					$pdf->Cell(35,8, '','',0 , 'L' );
					$pdf->Cell(100,8,' Biral Adarsha High School ','',0, 'L' );
					$pdf->Cell(15,7, '','',0 , '' );
					$pdf->Cell(35,8, '','',0 , 'L' );
					$pdf->Cell(100,8,' Biral Adarsha High School ','',1 , 'L' );
					
					   // $pdf->Image('image/dulogu.png',20,15,-250); // Left side image
					   // $pdf->Image('image/dulogu.png',170,15,-250);  // Right side image
                       // $pdf->Image('/students/'.$row['image'],110,20,-250);
					   // $pdf->Image('/students/'.$row['image'],260,20,-250);


			        $pdf->SetFont('Times','I','12');
					     $pdf->Cell(35,6, '','',0 , 'L' ); 
                         $pdf->Cell(100,6,'Biral, Dinajpur','' ,0 , 'L' );
						 $pdf->Cell(15,7, '|','',0 , 'L' );
						 $pdf->Cell(35,6, '','',0 , 'L' ); 
                         $pdf->Cell(100,6,'Biral, Dinajpur','' ,1 , 'L' );
						 
						 
				     $pdf->SetFont('Times','I','12');
					     $pdf->Cell(35,6, '','',0 , 'L' ); 
                         $pdf->Cell(65,6,' ','' ,0 , 'L' );
                         $pdf->Cell(35,6,'Student Copy','' ,0 , 'L' );
						 $pdf->Cell(15,7, '','',0 , 'L' );
                         $pdf->Cell(35,6, '','',0 , 'L' ); 
                         $pdf->Cell(65,6,' ','' ,0 , 'L' );
                         $pdf->Cell(35,6,'Admin Copy','' ,1 , 'L' );

						 
                         
                	         
						 
              $pdf->Cell(170,10,' ','',1 , 'R' );
			 
			  $pdf->SetFont('Times','I','14');   
		      $pdf->Cell(50,10,'Student Information ','B' ,0 , 'L' );
			  $pdf->Cell(20,10, '','',0 , '' );
		      $pdf->Cell(45,10,'INVOICE ','B' ,0 , 'L' );
			  $pdf->Cell(15,7, '','',0 , '' );
			  $pdf->Cell(20,10, '','',0 , '' );
			  $pdf->Cell(50,10,'Student Information ','B' ,0 , 'L' );
			  $pdf->Cell(20,10, '','',0 , '' );
		      $pdf->Cell(45,10,'INVOICE ','B' ,0, 'L' );
			  $pdf->Cell(20,10, '','',1, '' );
		 							 
					  
			  $pdf->SetFont('Times','I','12'); 
					
					     $pdf->Cell(15,7, 'Name ',0,0 , 'L' );
						 $pdf->Cell(55,7, ': Md Rayhan Babu','0',0 , 'L' );
						 $pdf->Cell(25,7, 'Invoice Month',0,0, 'L' );
						 $pdf->Cell(40,7, ': ',0,0, 'L' );
						 $pdf->Cell(15,7, '|','',0 , 'L' );
						 $pdf->Cell(15,7, 'Name ',0,0 , 'L' );
						 $pdf->Cell(55,7, ': Md Rayhan Babu','0',0 , 'L' );
						 $pdf->Cell(25,7, 'Invoice Month',0,0, 'L' );
						 $pdf->Cell(40,7, ': ',0,1, 'L' );
				          


						 $pdf->Cell(15,7, 'Stu Id',0,0 , 'L' );
						 $pdf->Cell(55,7, ': ','0',0 , 'L' );
						 $pdf->Cell(25,7, 'Invoice ID',0,0, 'L' );
						 $pdf->Cell(40,7, ': ',0,0, 'L' );
						 $pdf->Cell(15,7, '','',0 , '' );
						 $pdf->Cell(15,7, 'Stu Id',0,0 , 'L' );
						 $pdf->Cell(55,7, ': ','0',0 , 'L' );
						 $pdf->Cell(25,7, 'Invoice ID',0,0, 'L' );
						 $pdf->Cell(40,7, ': ',0,1, 'L' );
						
                         

						 $pdf->Cell(15,7, 'Roll No',0,0 , 'L' );
						 $pdf->Cell(55,7, ': ','0',0 , 'L' );
						 $pdf->Cell(25,7, 'Payment Type',0,0, 'L' );
						 $pdf->Cell(40,7, ': ',0,0, 'L' );
						 $pdf->Cell(15,7, '','',0 , '' );
						 $pdf->Cell(15,7, 'Roll No',0,0 , 'L' );
						 $pdf->Cell(55,7, ': ','0',0 , 'L' );
						 $pdf->Cell(25,7, 'Payment Type',0,0, 'L' );
						 $pdf->Cell(40,7, ': ',0,1, 'L' );
						
                         
				         $pdf->Cell(15,7, 'Phone',0,0 , 'L' );
						 $pdf->Cell(55,7, ': ','0',0 , 'L' );
						 $pdf->Cell(25,7, 'Payment Time',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(40,7, ': ',0,0, 'L' );
					$pdf->SetFont('Times','I','12');
					      $pdf->Cell(15,7, '','',0 , '' );
 						 $pdf->Cell(15,7,'Phone',0,0 , 'L' );
						 $pdf->Cell(55,7,': ','0',0 , 'L' );
						 $pdf->Cell(25,7,'Payment Time',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(40,7, ': ',0,1, 'L' );



                   $pdf->SetFont('Times','I','12');
                         $pdf->Cell(15,7, 'Class',0,0 , 'L' );
						 $pdf->Cell(55,7, ': ','0',0 , 'L' );
						 $pdf->Cell(25,7, 'Group ',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(40,7, ': ',0,0, 'L' );
					$pdf->SetFont('Times','I','12');
					      $pdf->Cell(15,7, '','',0 , '' );
 						 $pdf->Cell(15,7,'Class',0,0 , 'L' );
						 $pdf->Cell(55,7,': ','0',0 , 'L' );
						 $pdf->Cell(25,7,'Group ',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(40,7, ': ',0,1, 'L' );
						 

                  $pdf->SetFont('Times','I','12');
                         $pdf->Cell(15,7, 'Section',0,0 , 'L' );
						 $pdf->Cell(55,7, ': ','0',0 , 'L' );
						 $pdf->Cell(25,7, 'Shift ',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(40,7, ': ',0,0, 'L' );
					$pdf->SetFont('Times','I','12');
					      $pdf->Cell(15,7, '','',0 , '' );
 						 $pdf->Cell(15,7,'Section',0,0 , 'L' );
						 $pdf->Cell(55,7,': ','0',0 , 'L' );
						 $pdf->Cell(25,7,'Shift ',0,0, 'L' );
					$pdf->SetFont('Times','I','9'); 	 
						 $pdf->Cell(40,7, ': ',0,1, 'L' );       
						 					                    
                        									 
                          
                         $pdf->Cell(190,5,' ','',1 , 'C' );						  
					
                         $pdf->SetFont('Times','I','11');

					     $pdf->Cell(15,5, 'Serial',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Description',1,0 , 'L' );
						 $pdf->Cell(30,5, 'Amount',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , '' );
						 $pdf->Cell(15,5, 'Serial',1,0 , 'C' );
						 $pdf->Cell(80,5, 'Description',1,0 , 'L' );
						 $pdf->Cell(30,5, 'Amount',1,1 , 'R' ); 
						 
						 
						 $pdf->Cell(15,5, '1',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, 'TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , '' );
						 $pdf->Cell(15,5, '1',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, 'TK',1,1 , 'R' );
						 
						 $pdf->Cell(15,5, '2',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '|','',0 , 'C' );
						 $pdf->Cell(15,5, '2',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,1, 'R' );


                         $pdf->Cell(15,5, '3',1,0 , 'C' );
						 $pdf->Cell(80,5, '  ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, ' ','',0 , 'C' );
						 $pdf->Cell(15,5, '3',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,1, 'R' );

                         $pdf->Cell(15,5, '4',1,0 , 'C' );
						 $pdf->Cell(80,5, '  ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, ' ','',0 , 'C' );
						 $pdf->Cell(15,5, '4',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,1, 'R' );

                         $pdf->Cell(15,5, '5',1,0 , 'C' );
						 $pdf->Cell(80,5, '  ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, ' ','',0 , 'C' );
						 $pdf->Cell(15,5, '5',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,1, 'R' );


                         $pdf->Cell(15,5, '6',1,0 , 'C' );
						 $pdf->Cell(80,5, '  ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, ' ','',0 , 'C' );
						 $pdf->Cell(15,5, '6',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,1, 'R' );


                         $pdf->Cell(15,5, '7',1,0 , 'C' );
						 $pdf->Cell(80,5, '  ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, ' ','',0 , 'C' );
						 $pdf->Cell(15,5, '7',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,1, 'R' );


                         $pdf->Cell(15,5, '8',1,0 , 'C' );
						 $pdf->Cell(80,5, '  ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, ' ','',0 , 'C' );
						 $pdf->Cell(15,5, '8',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,1, 'R' );


                         $pdf->Cell(15,5, '9',1,0 , 'C' );
						 $pdf->Cell(80,5, '  ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, ' ','',0 , 'C' );
						 $pdf->Cell(15,5, '9',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,1, 'R' );


                         $pdf->Cell(15,5, '10',1,0 , 'C' );
						 $pdf->Cell(80,5, '  ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '','',0 , 'C' );
						 $pdf->Cell(15,5, '10',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,1, 'R' );
						  
						 
                         $pdf->Cell(15,5, '11',1,0 , 'C' );
						 $pdf->Cell(80,5, '  ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,0 , 'R' );
						 $pdf->Cell(25,5, '|','',0 , 'C' );
						 $pdf->Cell(15,5, '11',1,0 , 'C' );
						 $pdf->Cell(80,5, ' ',1,0 , 'L' );
						 $pdf->Cell(30,5, ' TK',1,1, 'R' );
						  
                         

						
					     $pdf->Cell(190,20,' ','',1 , 'C' );		
						 
						 
						 $pdf->Cell(40,7, 'Student Signature','',0 , 'C' );	
						 $pdf->Cell(95,7, 'Manager Signature','',0 , 'C' );
                         $pdf->Cell(25,7, '','',0 , '' );
						 $pdf->Cell(40,7, 'Student Signature','',0 , 'C' );	
						 $pdf->Cell(95,7, 'Manager Signature','',1 , 'C' );
						 		 
                // }	
                
                

					 
				  $pdf->Output('Rayhan babu.pdf','D');  
				 // $pdf->Output('Rayhan babu','I');
					 exit;
            	
					

?>