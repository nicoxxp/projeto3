<?php
	namespace Core;
	use Model\PaginaModel;
	use Controller\GenericController;

	Class Route
	{
			private static $paginaModel;
			private static $genericController;
			//private static $response_code;
			//private static $request_file;

			public static function init()
			{
				self::$paginaModel = new PaginaModel();
				self::$genericController = new GenericController();
			}

			/*
			*@date 29/02/2016
			*@return 
			*/
			public static function route()
			{
				self::init();

				//Loading Model Pagina :D
				$paginaModel = self::$paginaModel;

				//Getting parameters browser
				$strUrlParam = isset($_GET['pag']) ? $_GET['pag'] : null;

				//Loading pages of Database
				$arrPagina = $paginaModel->getAll();

				//Define routing
				$arrRoute = [
					'header' => array(
						'response_code' => 200,
						'request_file' => PAGES_SRC,
						'contentData' => null
					)
				];

				$strFileTmp = null;
				
				//Search url in arrPages Data
				foreach ($arrPagina as $key => $objPag)
				{
					if($objPag['dsc_lnk_page'] == $strUrlParam)
					{
						$strFileTmp = $arrRoute['header']['request_file'] . $objPag['source_page'];

						if(file_exists($strFileTmp) == false)
							$strFileTmp = null;
					}
				}

				if($strFileTmp == null)
				{
					$arrRoute['header']['response_code'] = 404;
					$arrRoute['header']['request_file'] .= "404.php";
				}
				else
				{
					$arrRoute['contentData'] = self::$genericController->getConteudoByLinkPagina($strUrlParam);
					$arrRoute['header']['request_file'] = $strFileTmp;
				}

				//Loading layout
				require_once(LAYOUT_SRC . 'layout-1.php');
			}
	}