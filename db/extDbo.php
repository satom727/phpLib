<?php

class Db
{
    private $pdo;
    private $query;
    private $pdoQuery;
    private $columns;
    private $resultArray;
    private $dtoClass;
    private $resultDto;
    // 接続とクエリを保持させる
    function __construct($sql,$pdo) {
        $this->columns = array();
        $this->query = $sql;
        $this->pdo = $pdo;
        $this->pdoQuery = $this->pdo->prepare($this->$query);
    }
    /** *****************
     * setter/getter
    ****************** */
    public function setDtoClass ($dtoClass){
        $this->dtoClass = $dtoClass;
    }
    public function getDtoClass (){
        return $this->dtoClass;
    }
    public function getPdo (){
        return $this->pdo;
    }
    public function getQuery (){
        return $this->query;
    }
    public function getPdoQuery (){
        return $this->pdoQuery;
    }
    public function getColumns (){
        return $this->columns;
    }
    public function getResultArray (){
        $this->fetchResultArray();        
        return $this->resultArray;
    }
    public function getResultDto (){
        $this->fetchResultDto();
        return $this->resultDto;
    }
    /** *****************
     * publicメソッド
    ****************** */
    // クエリに値を紐付ける
    public function bindValue($val_map){
        foreach ($val_map as $key => $val) {
            $this->pdoQuery->bindValue($val['paramName'],$val['value']);
        }
    }
    // SQLを実行する
    public function execute(){
        $this->pdoQuery->execute();
    }    
    /** *****************
     * privateメソッド
    ****************** */

    private function fetchResultArray(){
        $columnCnt = $this->dboQuery->columnCount();
        for ($i=0; $i < $columnCnt; $i++) { 
            $this->columns[] = new ColumnMetaData($this->pdoQuery->getColumnMeta($i));
        }
        $result = array();
        foreach ($this->columns as $key => $col) {
            $this->pdoQuery->bindColumn($col->getName(),$result[$col->getName()]);
        }
        while ($row = $this->pdoQuery-fetch(PDO::FETCH_BOUND)) {
            $this->resultArray[] = $result;
            // 配列にバインドできないなら以下
            // $res = array();
            // foreach ($this->columns as $key => $col) {
            //     $res[$col->getName()] = $result[$col->getName()];
            // }
        }
    }
    private function fetchResultDto (){
        $this->dto = $this->pdoQuery->fetchObject($this->dtoClass);
    }
}
