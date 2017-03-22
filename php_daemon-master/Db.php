<?php

    /**
     * Created by PhpStorm.
     * User: evolution
     * Date: 16-1-13
     * Time: 下午1:22
     */
//    class ExampleWorker extends Worker {
    class ExampleWorker {

        #protected $logger;
        protected  static $dbh;
        public function __construct() {

        }

        public function run(){
            $dbhost = '127.0.0.1';			// 数据库服务器
            $dbport = 3306;
            $dbuser = 'demo';        			// 数据库用户名
            $dbpass = '123456';             	// 数据库密码
            $dbname = 'example';				// 数据库名

            self::$dbh  = new PDO("mysql:host=$dbhost;port=$dbport;dbname=$dbname", $dbuser, $dbpass, array(
                    /* PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'', */
                    PDO::MYSQL_ATTR_COMPRESS => true,
                    PDO::ATTR_PERSISTENT => true
                )
            );

        }
        protected function getInstance(){
            return self::$dbh;
        }

    }


    /* the collectable class implements machinery for Pool::collect */
    class Fee extends Stackable {
        public function __construct($msg) {
            $trades = explode(",", $msg);
            $this->data = $trades;
            print_r($trades);
        }

        public function run() {
            #$this->worker->logger->log("%s executing in Thread #%lu", __CLASS__, $this->worker->getThreadId() );

            try {
                $dbh  = $this->worker->getInstance();

                $insert = "INSERT INTO fee(ticket, login, volume, `status`) VALUES(:ticket, :login, :volume,'N')";
                $sth = $dbh->prepare($insert);
                $sth->bindValue(':ticket', $this->data[0]);
                $sth->bindValue(':login', $this->data[1]);
                $sth->bindValue(':volume', $this->data[2]);
                $sth->execute();
                $sth = null;

                /* ...... */

                $update = "UPDATE fee SET `status` = 'Y' WHERE ticket = :ticket and `status` = 'N'";
                $sth = $dbh->prepare($update);
                $sth->bindValue(':ticket', $this->data[0]);
                $sth->execute();
                //echo $sth->queryString;
                //$dbh = null;
            }
            catch(PDOException $e) {
                $error = sprintf("%s,%s\n", $mobile, $id );
                file_put_contents("mobile_error.log", $error, FILE_APPEND);
            }
        }
    }

    $a = new Fee();
    print_r($a); exit;