<?php

// Pour lancer le test depuis la console : se placer dans TDPersistent et tapper : phpunit --verbose OrderTest

	class Order
	{
		protected $articles;
	 
		public function __construct()
		{
			$this->articles = array();
		}
	 
		/**
		 * Ajoute un article à la commande
		 * @param string $reference
		 * @param int $quantity
		 */    
		public function addArticle($reference, $quantity = 1)
		{
			$this->articles[$reference] = $quantity;
		}
	 
		/**
		 * Modifie la quantité d'une référence
		 * @param string $reference
		 * @param int $quantity
		 * @throws InvalidArgumentException
		 */
		public function updateQuantity($reference, $quantity)
		{
			if (!array_key_exists($reference, $this->articles)) {
				throw new InvalidArgumentException('reference not ordered');
			}        
			$this->articles[$reference] = $quantity;
		}
	 
		public function getArticles()
		{
			return $this->articles;
		}
	}	
	
	class OrderTest extends PHPUnit_Framework_TestCase
	{
		protected $order;
	 
		//cette méthode est executé avant chaque test, son homologue tearDown, est executé après chaque test
		public function setUp()
		{
			 if (null == $this->order) {
				  $this->order = new Order();
			 }
		}
	 
		/**
		 * Test constructeur
		 */
		public function testConstruct()
		{
			//on teste que l'attribut articles a bien été instancié comme un tableau vide
			$this->assertAttributeInternalType('array', 'articles', $this->order);
			$this->assertAttributeCount(0, 'articles', $this->order);
		}
	}
