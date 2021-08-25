<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once('C:\laragon\www\nfe\vendor\autoload.php');

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;
use NFePHP\NFe\Common\FakePretty;
use NFePHP\NFe\Common\Standardize;

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
				"razaosocial" => "TESTE",
				"cnpj"        => "99999999999999",
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
			$content = file_get_contents('C:\laragon\www\nfe\vendor\nfephp-org\sped-nfe\fake\FAST_SHOP_S_A_43708379000100_1596646291895871200.pfx'); // caminho completo do certificado
			$tools = new Tools($configJson, Certificate::readPfx($content, 'Ffiscal@2020')); //senha do certificado
			$tools->model('55');

			//Coloque a chave aqui
			$chave = "35190643708379012965550010002413151000000014";

			$response = $tools->sefazConsultaChave($chave);

			//você pode padronizar os dados de retorno atraves da classe abaixo
			//de forma a facilitar a extração dos dados do XML
			//NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
			//      quando houver a necessidade de protocolos
			$stdCl = new Standardize($response);
			$arr = $stdCl->toArray();

			// echo $json;
			echo '<pre>';
			print_r($arr);
			echo '</pre>';

			// echo FakePretty::prettyPrint($std);
		} catch (\Exception $e) {
			echo $e->getMessage();
		}
	}
}
