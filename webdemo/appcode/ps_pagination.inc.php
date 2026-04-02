<style>
.a2
{
    font-family: verdana;
    font-size: 12px;
    color: red;
    font-weight: bolder;
    text-decoration: none;
}
a2:hover 
{
      color:  #830808;
}
.c
{
    font-family: verdana;
    font-size: 12px;
    color: black;    
    text-decoration: none;
}
/*a
{
    font-family: verdana;
    font-size: 9px;
    color: #5e7794;
    font-weight: bolder;
    text-decoration: None;
}
a:hover
{
    color: #e81120;
}*/
</style>
<?php 

require_once("usercon_pdo.inc.php");
require_once("ForAjax.inc.php");




class PS_Pagination {	
    var $php_self;
	var $rows_per_page = 10; //Number of records to display per page
	var $total_rows ; //Total number of rows returned by the query
    var $links_per_page = 5; //Number of links to display per page
	var $append = ""; //Paremeters to append to pagination links
	var $sql = "";
	var $debug = false;
	var $conn = false;
	var $page = 1;
	var $max_pages = 0;
	var $offset = 0;	
    var $prs='';
    
	/**
	 * Constructor
	 *
	 * @param resource $connection Mysql connection link
	 * @param string $sql SQL query to paginate. Example : SELECT * FROM users
	 * @param integer $rows_per_page Number of records to display per page. Defaults to 10
	 * @param integer $links_per_page Number of links to display per page. Defaults to 5
	 * @param string $append Parameters to be appended to pagination links 
	 */
	
	function __construct($connection, $sql, $rows_per_page = 10, $links_per_page = 5, $append = "") {	   
         global $obj;
       //$this->obj->open_db();       
		//$this->conn = open_db();
        $this->conn = db_connect();
		$this->sql = $sql;
		$this->rows_per_page = (int)$rows_per_page;
		if (intval($links_per_page ) > 0) {
			$this->links_per_page = (int)$links_per_page;
		} else {
			$this->links_per_page = 5;
		}
		$this->append = $append;
		$this->php_self = htmlspecialchars($_SERVER['PHP_SELF'] );
		if (isset($_GET['page'] )) {
			$this->page = intval($_GET['page'] );
		}
	}
	
	/**
	 * Executes the SQL query and initializes internal variables
	 *
	 * @access public
	 * @return resource
	 */
	function paginate() {
	   global $obj;
		//Check for valid mysql connection
        #$obj=new mysql_conn();
        
        
        
	/*	if (! $this->conn || ! is_resource($this->conn )) {
			if ($this->debug)
				echo "MySQL connection missing<br />";
			return false;
		}*/
		
		//Find total number of rows
		//$all_rs = @mysql_query($this->sql );
        /*$start = 'select';
        $end  = 'from';
        $CountQry = preg_replace('#('.$start.')(.*)('.$end.')#si', '$1 count(*) $3', $this->sql);*/        
        #$all_rs=(getNameQry($CountQry));
        $all_rs=(simplefetch($this->sql));
		if (! $all_rs) {
			if ($this->debug)
				echo "SQL query failed. Check your query.<br /><br />Error Returned: " . mysqli_error(db_connect());
			return false;
		}
		//$this->total_rows = mysql_num_rows($all_rs );
        $this->total_rows = $all_rs[0];
        #$this->total_rows = $all_rs;        
		//@mysql_close($all_rs );
		
		//Return FALSE if no rows found
		if ($this->total_rows == 0) {
			if ($this->debug)
				echo "Query returned zero rows.";
			return FALSE;
		}
		
		//Max number of pages
	 	$this->max_pages = ceil($this->total_rows / $this->rows_per_page );
		if ($this->links_per_page > $this->max_pages) {
			$this->links_per_page = $this->max_pages;
		}
		
		//Check the page value just in case someone is trying to input an aribitrary value
		if ($this->page > $this->max_pages || $this->page <= 0) {
			$this->page = 1;
		}
	
		//Calculate Offset
	     $this->offset = $this->rows_per_page * ($this->page - 1);
		
		//Fetch the required result set
		//$rs = @mysql_query($this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}" );
        $this->prs=simplefetch($this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}" );
        $this->prs[2]=$this->offset;
        $this->prs[3]=$this->page;
        $this->prs[4]=$this->max_pages;
        
		if (! $this->prs) {
			if ($this->debug)
				echo "Pagination query failed. Check your query.<br /><br />Error Returned: " . mysqli_error(db_connect());
			return false;
		}
		return $this->prs;
	}
	
	/**
	 * Display the link to the first page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'First'
	 * @return string
	 */
	function renderFirst($tag = 'First') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page == 1) {
			return "<li class='disabled'><a href='javascript:void(0);'> $tag </a> </li>";
		} else {
			return '<li><a href="' . $this->php_self . '?page=1&' . $this->append . '">' . $tag . '</a> </li>';
		}
	}
	
	/**
	 * Display the link to the last page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'
	 * @return string
	 */
	function renderLast($tag = 'Last') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page == $this->max_pages) {
			return "<li class='disabled'><a href='javascript:void(0);'> $tag </a></li>";
		} else {
			return '<li> <a href="' . $this->php_self . '?page=' . $this->max_pages . '&' . $this->append . '">' . $tag . '</a></li>';
		}
	}
	
	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string
	 */
	function renderNext($tag = '&gt;&gt;') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page < $this->max_pages) {
			return '<li><a href="' . $this->php_self . '?page=' . ($this->page + 1) . '&' . $this->append . '">' . $tag . '</a></li>';
		} else {
			#return "<span class='c'>$tag </span>";
            return '<li><a id="next" href="javascript:void(0);">'.$tag.'</a></li>';
		}
	}
	
	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
	function renderPrev($tag = '&lt;&lt;') {
		if ($this->total_rows == 0)
			return FALSE;
		
		if ($this->page > 1) {
			return '<li> <a href="' . $this->php_self . '?page=' . ($this->page - 1) . '&' . $this->append . '">' . $tag . '</a></li>';
		} else {
			#return "<span class='c'>$tag </span>";
            return '<li><a id="prev" href="javascript:void(0);">'.$tag.'</a></li>';
		}
	}
	
	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
	function renderNav($prefix = '<li>', $suffix = '</li>') {
		if ($this->total_rows == 0)
			return FALSE;
		
		$batch = ceil($this->page / $this->links_per_page );
		$end = $batch * $this->links_per_page;
		if ($end == $this->page) {
			//$end = $end + $this->links_per_page - 1;
		//$end = $end + ceil($this->links_per_page/2);
		}
		if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		$start = $end - $this->links_per_page + 1;
		$links = '';
		
		for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page) {			     
				$links .= str_replace('>',' class="active">',$prefix) . "<a href='javascript:void(0);'> $i </a>" . $suffix;
			} else {
				$links .= ' ' . $prefix . '<a href="' . $this->php_self . '?page=' . $i . '&' . $this->append . '">' . $i . '</a>' . $suffix . ' ';
			}
		}
		
		return $links;
	}
	
	/**
	 * Display full pagination navigation
	 *
	 * @access public
	 * @return string
	 */
	function renderFullNav() {
		#return $this->renderFirst() . '&nbsp;' . $this->renderPrev() . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext() . '&nbsp;' . $this->renderLast();
        return '<ul class="pagination">'.$this->renderFirst('&#124;&#60;') . $this->renderPrev() . $this->renderNav() . $this->renderNext() . $this->renderLast('&#62;&#124;').'</ul>';
	}
    
    
    
    /**
     * 
     * Display bootstrap style pagination
     * 
     */
     
     function renderBootNav(){
        return '<ul class="pagination">'.$this->renderPrev('&laquo;').$this->renderNav('<li>','</li>').$this->renderNext('&raquo;').'</ul>';
     }
	
	/**
	 * Set debug mode
	 *
	 * @access public
	 * @param bool $debug Set to TRUE to enable debug messages
	 * @return void
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}
}
?>
