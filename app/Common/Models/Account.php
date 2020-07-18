<?php

namespace App\Common\Models;

use Nette\Object;
use Kdyby\Doctrine\EntityDao;
use App\Common\Entities\AccountEntity;

class Account extends Object
{

	public $accountDao;

	public function __construct(EntityDao $accountDao)
	{
		$this->accountDao = $accountDao;
	}

	/**
	 * @param integer $id
	 * @return AccountEntity
	 */
	public function getAccountById($id)
	{
		return $this->accountDao->findOneBy(['id' => $id]);
	}

	/**
	 *
	 * @param array $criteria
	 * @return AccountEntity
	 */
	public function findOneBy(array $criteria)
	{
		return $this->accountDao->findOneBy($criteria);
	}

	/**
	 * @param AccountEntity $accountEntity
	 */
	public function save(AccountEntity $accountEntity)
	{
		$em = $this->accountDao->getEntityManager();
		$em->persist($accountEntity);
		$em->flush();
	}

}