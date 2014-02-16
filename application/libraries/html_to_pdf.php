<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
Parameters for $mpdf->Output(filename,dest)
------------------------------
filename
	The name of the file. If not specified, the document will be sent to the browser (destination I).
	BLANK or omitted: "doc.pdf"

dest
	Destination where to send the document.
	DEFAULT: "I" i.e. Browser

	I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
	D: send to the browser and force a file download with the name given by filename.
	F: save to a local file with the name given by filename (may include a path).
	S: return the document as a string. filename is ignored.
*/

class Html_to_pdf
{
	function __construct()
	{
		$this->ci =& get_instance();
		include("MPDF/mpdf.php");
	}
	
	public function get_pdf_from_html($html)
	{
		$mpdf=new mPDF();
		$mpdf->WriteHTML($html);
		return $mpdf->Output('','S');
	}
	
	public function view_pdf_from_html($filename,$html)
	{
		$mpdf=new mPDF();
		//$mpdf->SetHTMLHeader($header);
		//$mpdf->setFooter('Page {PAGENO}');
		$mpdf->WriteHTML($html);
		return $mpdf->Output($filename,'D');
	}
	
	public function make_pdf_from_html($output_file,$html,$header)
	{
		$mpdf=new mPDF();
		$mpdf->SetHTMLHeader($header);
		$mpdf->setFooter('Page {PAGENO}');
		$mpdf->WriteHTML($html);
		return $mpdf->Output($output_file,'F');
	}
	
}