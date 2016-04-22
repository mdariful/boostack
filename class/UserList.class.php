<?php
/**
 * Created by PhpStorm.
 * User: Md Ariful
 * Date: 15/04/2016
 * Time: 14.47
 */
class UserList
{
    private $order_type;
    private $order_mode;
    private $for_page;
    private $current_page;
    private $total = 0;
    private $list;
    private $pdo;

    const USER_TABLE = "boostack_user";
    const USER_INFO_TABLE = "boostack_user_info";
    const USER_REGISTRATION_TABLE = "boostack_user_registration";

    public function __construct()
    {
        $order_type = "id";
        $order_mode = "DESC";
        $this->for_page = 30;
        $this->current_page = 1;
        $this->pdo = Database_PDO::getInstance();
        $this->list = [];
    }

    public function __get($propertyName)
    {
        if (isset($this->$propertyName)) return $this->$propertyName;
        else return null;
    }

    public function __set($property_name, $val)
    {
        $this->$property_name = $val;
    }

    public function getProductList()
    {
        return $this->list;
    }

    public function length()
    {
        $this->total = count($this->list);
        return $this->total;
    }

    public function activeUser($active){
        $q = $this->pdo->prepare("SELECT * FROM ".self::USER_TABLE." WHERE ACTIVE=".$active.";");
        $q->execute();

        $rows = $q->fetchAll(PDO::FETCH_OBJ);
        foreach ($rows as $users) $this->list[] = $users;

        return $this->list;
    }

    public function getUsers($active, $privilege)
    {
        $start = $this->for_page * ($this->current_page - 1);
        $end = $start + ($this->for_page - 1) + 1;
        $end = $this->for_page;

        $q = $this->pdo->prepare("SELECT DISTINCT ".self::USER_TABLE.".*
                                  FROM ".self::USER_TABLE.", ".self::USER_INFO_TABLE.", ".self::USER_REGISTRATION_TABLE."
                                  WHERE ".self::USER_TABLE.".active = :active AND privilege >= :privilege AND id <> 1
                                  ORDER BY '".$this->order_type."' ".$this->order_mode."
                                  LIMIT ".$start.",".$end." "
        );
        $q->bindParam(":active", $active);
        $q->bindParam(":privilege", $privilege);
        $q->execute();

        $rows = $q->fetchAll(PDO::FETCH_OBJ, 'User');
        foreach ($rows as $u) $this->list[] = $u;

        return $this->list;
    }

    public function loadAllPaginate($active, $privilege)
    {
        if(is_null($active)) $queryPart = "WHERE active = '1'";
        else if($active == 0) $queryPart = "WHERE active = '0'";
        else if($active == 1) $queryPart = "WHERE active = '1'";

        $queryPart .= " AND privilege >= :privilege ";

        $offset = $this->for_page * ($this->current_page - 1);

        $q = $this->pdo->prepare("SELECT * "." FROM ".self::USER_TABLE.";");
        $q->bindParam(":privilege", $privilege);


        $q->execute();

        $rows = $q->fetchAll(PDO::FETCH_OBJ);
        foreach ($rows as $users) $this->list[] = $users;

        return $this->list;
    }

    public function Init($where="",$like=""){
        $total = mysql_query("SELECT id FROM ".self::TABLENAME." ")or die (mysql_error());
        $this->total_user = mysql_num_rows($total);

        $start = $this->for_page * ($this->current_page - 1);
        $end = $start + ($this->for_page - 1) + 1;
        $end = $this->for_page;
        if(is_array($where)){
            $where_sql = "";
            $i = 0; $c = count($where);
            $and = "WHERE ";
            while($i < $c){
                if($i>1)
                    $and = " AND ";
                $where_sql .= $and.$where[$i]."='".$where[$i+1]."'";
                $i = $i+2;
            }
        }
        else
            $where_sql = $where;

        if($where == "")
            $like_sql = "WHERE ";
        else
            if($like !="")
                $like_sql = "AND ";
            else
                $like_sql = "";

        $like_sql .= ($like !="")? "".$like[0]." LIKE '%".$like[1]."%'" : $like;

        $sql = "SELECT id FROM ".self::TABLENAME." ".$where_sql." ".$like_sql."
      ORDER BY ".$this->order_type." ".$this->order_mode."  LIMIT ".$start.",".$end." ";
        $fields2 = mysql_query($sql)or die (mysql_error().": $sql");

        while ($fields = mysql_fetch_array($fields2)){
            $this->user_list[$fields["id"]] = new User($fields["id"]);
        }
    }

    public function totalPages($active, $privilege) {
        if(is_null($active)) $queryPart = "WHERE active = '1'";
        else if($active == 0) $queryPart = "WHERE active = '0'";
        else if($active == 1) $queryPart = "WHERE active = '1'";

        $queryPart .= " AND privilege > :privilege";

        $q = $this->pdo->prepare("SELECT count(id) FROM ".self::USER_TABLE." ".$queryPart);
        $q->bindParam(":privilege", $privilege);
        $q->execute();
        $this->total = $q->fetchColumn();
        //echo "+Totale : $this->total+";
        return ceil($this->total / $this->for_page);
    }

    public function getUsersWithMailLike($searchTerm, $privilege, $visible = null)
    {
        if(is_null($visible)) $queryPart = " AND active = '1'";
        else if($visible == 0) $queryPart = " AND active = '0'";
        else if($visible == 1) $queryPart = " AND active = '1'";

        $q = $this->pdo->prepare("SELECT id, email
                                  FROM boostack_user
                                  WHERE email LIKE :term AND privilege >= :privilege $queryPart
                                  ORDER BY email ASC LIMIT 0,10");

        $searchTerm = "%$searchTerm%";

        $q->bindParam(":term", $searchTerm);
        $q->bindParam(":privilege", $privilege);


        //echo $searchTerm. " " . $privilege;
        $q->execute();

        //echo "5";

        $rows = $q->fetchall(PDO::FETCH_CLASS, 'User');
        foreach ($rows as $user) {
            $this->list[] = $user;
        }
        //echo "6";

        return $this->list;
    }

    public function printPagesBar($uri, $totalpages=null) {
        $res = "";
        $start = 1;
        $end =  $totalpages != null ? $totalpages : $this->totalPages();
        if($start == $end)
            return $res;
        if($start != $this->current_page)
            $res .= "<li>
                        <a href=\"".$uri."/".($this->current_page-1)."\" aria-label=\"Previous\">
                        <span aria-hidden=\"true\">&laquo;</span>
                        </a>
                    </li>";

        for($i = $start; $i <= $end ; $i++){
            $active = "";
            if($i == $this->current_page)
                $active = "class=\"active\"";
            $res .= "<li ".$active."><a href=".$uri."/".$i.">".$i."</a></li>";
        }

        if($end != $this->current_page)
            $res .= "<li>
                        <a href=\"".$uri."/".($this->current_page+1)."\" aria-label=\"Next\">
                        <span aria-hidden=\"true\">&raquo;</span>
                        </a>
                    </li>";

        return $res;
    }

}