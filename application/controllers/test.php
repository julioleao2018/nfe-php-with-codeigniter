<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once('C:\laragon\www\nfe\vendor\autoload.php');

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;
use NFePHP\NFe\Common\FakePretty;

class Welcome extends CI_Controller
{
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

		// phpinfo();

		try {

			$arr = [
				"atualizacao" => "2016-11-03 18:01:21",
				"tpAmb"       => 1,
				"razaosocial" => "SUA RAZAO SOCIAL LTDA",
				"cnpj"        => "43708379006485",
				"siglaUF"     => "SP",
				"schemes"     => "PL_009_V4",
				"versao"      => '4.00',
				"tokenIBPT"   => "AAAAAAA",
				"CSC"         => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
				"CSCid"       => "000001",
				"proxyConf"   => [
					"proxyIp"   => "",
					"proxyPort" => "",
					"proxyUser" => "",
					"proxyPass" => ""
				]
			];
			$configJson = json_encode($arr);
			$soap = new SoapFake();
			$soap->disableCertValidation(true);

			$content = file_get_contents('C:\laragon\www\nfe\vendor\nfephp-org\sped-nfe\fake\FAST_SHOP_S_A_43708379000100_1596646291895871200.pfx');
			$tools = new Tools($configJson, Certificate::readPfx($content, 'Ffiscal@2020'));
			$tools->model('55');
			$tools->setVerAplic('5.1.34');
			$tools->loadSoapClass($soap);

			$chave = "35161143708379006485550100001738591000000011";
			
			$response = $tools->sefazConsultaChave($chave);

			echo FakePretty::prettyPrint($response);
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}
}
