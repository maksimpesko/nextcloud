<?php
/**
 * @copyright Copyright (c) 2016, ownCloud, Inc.
 *
 * @author Arthur Schiwon <blizzz@arthur-schiwon.de>
 * @author Joas Schilling <coding@schilljs.com>
 * @author Jörn Friedrich Dreyer <jfd@butonic.de>
 * @author Morris Jobke <hey@morrisjobke.de>
 * @author Robin Appelman <robin@icewind.nl>
 * @author Robin McCorkell <robin@mccorkell.me.uk>
 * @author Thomas Müller <thomas.mueller@tmit.eu>
 * @author Vincent Petry <vincent@nextcloud.com>
 *
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program. If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OC\Files\Cache;

use OCP\Files\Storage\IStorage;
use Psr\Log\LoggerInterface;

/**
 * Handle the mapping between the string and numeric storage ids
 *
 * Each storage has 2 different ids
 * 	a string id which is generated by the storage backend and reflects the configuration of the storage (e.g. 'smb://user@host/share')
 * 	and a numeric storage id which is referenced in the file cache
 *
 * A mapping between the two storage ids is stored in the database and accessible trough this class
 *
 * @package OC\Files\Cache
 */
class Storage {
	/** @var StorageGlobal|null */
	private static $globalCache = null;
	private $storageId;
	private $numericId;

	/**
	 * @return StorageGlobal
	 */
	public static function getGlobalCache() {
		if (is_null(self::$globalCache)) {
			self::$globalCache = new StorageGlobal(\OC::$server->getDatabaseConnection());
		}
		return self::$globalCache;
	}

	/**
	 * @param \OC\Files\Storage\Storage|string $storage
	 * @param bool $isAvailable
	 * @throws \RuntimeException
	 */
	public function __construct($storage, $isAvailable = true) {
		if ($storage instanceof IStorage) {
			$this->storageId = $storage->getId();
		} else {
			$this->storageId = $storage;
		}
		$this->storageId = self::adjustStorageId($this->storageId);

		if ($row = self::getStorageById($this->storageId)) {
			$this->numericId = (int)$row['numeric_id'];
		} else {
			$connection = \OC::$server->getDatabaseConnection();
			$available = $isAvailable ? 1 : 0;
			if ($connection->insertIfNotExist('*PREFIX*storages', ['id' => $this->storageId, 'available' => $available])) {
				$this->numericId = (int)$connection->lastInsertId('*PREFIX*storages');
			} else {
				if ($row = self::getStorageById($this->storageId)) {
					$this->numericId = (int)$row['numeric_id'];
				} else {
					throw new \RuntimeException('Storage could neither be inserted nor be selected from the database: ' . $this->storageId);
				}
			}
		}
	}

	/**
	 * @param string $storageId
	 * @return array
	 */
	public static function getStorageById($storageId) {
		return self::getGlobalCache()->getStorageInfo($storageId);
	}

	/**
	 * Adjusts the storage id to use md5 if too long
	 * @param string $storageId storage id
	 * @return string unchanged $storageId if its length is less than 64 characters,
	 * else returns the md5 of $storageId
	 */
	public static function adjustStorageId($storageId) {
		if (strlen($storageId) > 64) {
			return md5($storageId);
		}
		return $storageId;
	}

	/**
	 * Get the numeric id for the storage
	 *
	 * @return int
	 */
	public function getNumericId() {
		return $this->numericId;
	}

	/**
	 * Get the string id for the storage
	 *
	 * @param int $numericId
	 * @return string|null either the storage id string or null if the numeric id is not known
	 */
	public static function getStorageId($numericId) {
		$query = \OC::$server->getDatabaseConnection()->getQueryBuilder();
		$query->select('id')
			->from('storages')
			->where($query->expr()->eq('numeric_id', $query->createNamedParameter($numericId)));
		$result = $query->execute();
		$row = $result->fetch();
		$result->closeCursor();
		if ($row) {
			return $row['id'];
		} else {
			return null;
		}
	}

	/**
	 * Get the numeric of the storage with the provided string id
	 *
	 * @param $storageId
	 * @return int|null either the numeric storage id or null if the storage id is not knwon
	 */
	public static function getNumericStorageId($storageId) {
		$storageId = self::adjustStorageId($storageId);

		if ($row = self::getStorageById($storageId)) {
			return (int)$row['numeric_id'];
		} else {
			return null;
		}
	}

	/**
	 * @return array|null [ available, last_checked ]
	 */
	public function getAvailability() {
		if ($row = self::getStorageById($this->storageId)) {
			return [
				'available' => (int)$row['available'] === 1,
				'last_checked' => $row['last_checked']
			];
		} else {
			return null;
		}
	}

	/**
	 * @param bool $isAvailable
	 * @param int $delay amount of seconds to delay reconsidering that storage further
	 */
	public function setAvailability($isAvailable, int $delay = 0) {
		$available = $isAvailable ? 1 : 0;
		if (!$isAvailable) {
			\OC::$server->get(LoggerInterface::class)->info('Storage with ' . $this->storageId . ' marked as unavailable', ['app' => 'lib']);
		}

		$query = \OC::$server->getDatabaseConnection()->getQueryBuilder();
		$query->update('storages')
			->set('available', $query->createNamedParameter($available))
			->set('last_checked', $query->createNamedParameter(time() + $delay))
			->where($query->expr()->eq('id', $query->createNamedParameter($this->storageId)));
		$query->execute();
	}

	/**
	 * Check if a string storage id is known
	 *
	 * @param string $storageId
	 * @return bool
	 */
	public static function exists($storageId) {
		return !is_null(self::getNumericStorageId($storageId));
	}

	/**
	 * remove the entry for the storage
	 *
	 * @param string $storageId
	 */
	public static function remove($storageId) {
		$storageId = self::adjustStorageId($storageId);
		$numericId = self::getNumericStorageId($storageId);

		$query = \OC::$server->getDatabaseConnection()->getQueryBuilder();
		$query->delete('storages')
			->where($query->expr()->eq('id', $query->createNamedParameter($storageId)));
		$query->execute();

		if (!is_null($numericId)) {
			$query = \OC::$server->getDatabaseConnection()->getQueryBuilder();
			$query->delete('filecache')
				->where($query->expr()->eq('storage', $query->createNamedParameter($numericId)));
			$query->execute();
		}
	}
}
