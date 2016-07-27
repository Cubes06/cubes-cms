<?php

    class Admin_TestController extends Zend_Controller_Action {

        public function indexAction() {
            die();
        }

        public function jsintroAction() {

        }

        public function jqueryAction() {

        }

        public function ajaxintroAction() {

        }

        public function ajaxbrandsAction() {
            $brands = array(
                'fiat' => array(
                    'punto' => 'Punto',
                    'stilo' => 'Stilo',
                    '500l' => '500 L'
                ),
                'opel' => array(
                    'corsa' => 'Corsa',
                    'astra' => 'Astra',
                    'vectra' => 'Vectra',
                    'insignia' => 'Insignia'
                ),
                'renault' => array(
                    'twingo' => 'Twingo',
                    'clio' => 'Clio',
                    'megane' => 'Megane',
                    'scenic' => 'Scenic'
                )
            );
            
            $brandsJson = array();
            
            foreach ($brands as $brand => $models) {
                $brandsJson[] = array(
                    'value' => $brand,
                    'label' => ucfirst($brand)
                );
            }
            
            //Zend_Layout::getMvcInstance()->disableLayout();
            
            //disable view script rendering
            //$this->getHelper('ViewRenderer')->setNoRender(true);
            
            //set content type as json instead of html
            //header('Content-Type: application/json');
            //echo json_encode($brandsJson);
            
            $this->getHelper('Json')->sendJson($brandsJson); //uradi sve ovo gore iskomentarisano
        }

        public function ajaxmodelsAction() {
            $brands = array(
                'fiat' => array(
                    'punto' => 'Punto',
                    'stilo' => 'Stilo',
                    '500l' => '500 L'
                ),
                'opel' => array(
                    'corsa' => 'Corsa',
                    'astra' => 'Astra',
                    'vectra' => 'Vectra',
                    'insignia' => 'Insignia'
                ),
                'renault' => array(
                    'twingo' => 'Twingo',
                    'clio' => 'Clio',
                    'megane' => 'Megane',
                    'scenic' => 'Scenic'
                )
            );
            
            $request = $this->getRequest();
            
            $brand = $request->getParam('brand');
            
            if (!isset($brands[$brand])) {
                throw new Zend_Controller_Router_Exception('Unknown brand', 404);
            }
            
            $models = $brands[$brand];
            $modelsJson = array();
            
            foreach ($models as $modelId => $modelLabel) {
                $modelsJson[] = array(
                    "value" => $modelId,
                    "label" => $modelLabel
                );
            }
            
            $this->getHelper("Json")->sendJson($modelsJson);
            
        }

    }
