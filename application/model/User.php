<?php

use Famework\Registry\Famework_Registry;

abstract class User {

    public static function generatePasswordHash($pwd, $salt) {
        return hash_pbkdf2('sha256', $pwd, $salt, 1000, 64);
    }

    public static function verifyMailAddress($name, $email) {
        $stm = Famework_Registry::getDb()->prepare('SELECT email FROM user WHERE name = ? AND email = ? AND activated = 1 LIMIT 1');
        $stm->execute(array($name, $email));

        $res = NULL;

        foreach ($stm->fetchAll() as $row) {
            $res = $row['email'];
        }

        return $res;
    }

    public static function resetPwd($hash, $email, $pwd) {
        // use 32 bit salt
        $newsalt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        // generate pwd hash
        $newpwd = self::generatePasswordHash($pwd, $newsalt);
        // update data
        $stm = Famework_Registry::getDb()->prepare('UPDATE user SET hash = NULL, pwd = ?, salt = ? WHERE email = ? AND hash = ?');
        $stm->execute(array($newpwd, $newsalt, $email, $hash));
        // check data
        $count = (int) $stm->rowCount();
        return ($count === 1 ? TRUE : FALSE);
    }

    /**
     * @var PDO
     */
    protected $_db;
    protected $_username;
    protected $_email;
    protected $_id;
    protected $_meta = NULL;

    protected function initDb() {
        if (!isset($this->_db)) {
            $this->_db = Famework_Registry::getDb();
        }

        return $this->_db;
    }

    public function getId() {
        return (int) $this->_id;
    }

    public function getName() {
        return $this->getWhatever('name');
    }

    protected function loadMeta() {
        $id = $this->_id;
        $stm = $this->_db->prepare('SELECT * FROM user WHERE id = :id LIMIT 1');
        $stm->bindParam(':id', $id);
        $stm->execute();

        $this->_meta = $stm->fetch();

        if (empty($this->_meta)) {
            throw new Exception('User not found.');
        }

        $this->_email = $this->_meta['email'];
        $this->_username = $this->_meta['name'];
    }

    protected function getWhatever($key) {
        if (!isset($this->_meta[$key])) {
            $this->loadMeta();
        }

        return $this->_meta[$key];
    }

    public function getPictureUrl($size) {
        $path = $this->getPicturePath($size);

        if (is_readable($path) === TRUE) {
            return '/' . APPLICATION_LANG . '/upload/userpic/?id=' . $this->getId() . '&size=' . $size;
        }

        return '/img/profile256.png';
    }

    protected abstract function getPicturePath($size);
}
