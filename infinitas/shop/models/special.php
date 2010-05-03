<?php
	class Special extends ShopAppModel{
		var $name = 'Special';

		var $belongsTo = array(
			'Image' => array(
				'className' => 'Shop.Image',
				'foreignKey' => 'image_id',
				'fields' => array(
					'Image.id',
					'Image.image',
					'Image.width',
					'Image.height'
				),
				'conditions' => array(),
				'order' => array(
					'Image.image' => 'ASC'
				)
			),
			'Product' => array(
				'className' => 'Shop.Product',
				'foreignKey' => 'product_id',
				'fields' => array(
					'Product.id',
					'Product.name',
					'Product.image_id',
					'Product.cost',
					'Product.retail',
					'Product.price',
					'Product.active',
					'Product.image_id',
				),
				'conditions' => array(),
				'order' => array(
					'Product.name' => 'ASC'
				)
			)
		);

		var $hasAndBelongsToMany = array(
			'ShopBranch' => array(
				'className' => 'Shop.ShopBranch',
				'foreignKey' => 'branch_id',
				'associationForeignKey' => 'special_id',
				'with' => 'Shop.BranchesSpecial',
				'unique' => true,
				'conditions' => '',
				'fields' => array(
					'ShopBranch.id',
					'ShopBranch.name'
				),
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			),
		);

		function getSpecials($limit = 10){
			$specials = $this->find(
				'all',
				array(
					'fields' => array(
						'Special.id',
						'Special.image_id',
						'Special.amount',
						'Special.active',
						'Special.start_date',
						'Special.end_date'
					),
					'conditions' => array(
						'Special.active' => 1,
						'and' => array(
							'CONCAT(`Special`.`start_date`, " ", `Special`.`start_time`) <= ' => date('Y-m-d H:i:s'),
							'CONCAT(`Special`.`end_date`, " ", `Special`.`end_time`) >= ' => date('Y-m-d H:i:s')
						)
					),
					'contain' => array(
						'Product' => array(
							'fields' => array(
								'Product.id',
								'Product.name',
								'Product.slug',
								'Product.price',
								'Product.retail',
								'Product.description'
							),
							'Image',
							'ProductCategory'
						),
						'Image'
					),
					'limit' => $limit
				)
			);

			return $specials;
		}
	}