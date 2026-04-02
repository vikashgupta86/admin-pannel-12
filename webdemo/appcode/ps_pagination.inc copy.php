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
require_once("ForAjax.inc.php");

	/**
	 * Executes the SQL query and initializes internal variables
	 *
	 * @access public
	 * @return resource
	 */
function ps_pagination_init($conn, $sql, $rows_per_page = 10, $links_per_page = 5, $append = "")
{
    $p = [];

    $p['conn'] = $conn;
    $p['sql'] = $sql;
    $p['rows_per_page'] = (int)$rows_per_page;
    $p['links_per_page'] = ($links_per_page > 0) ? (int)$links_per_page : 5;
    $p['append'] = $append;
    $p['php_self'] = htmlspecialchars($_SERVER['PHP_SELF']);
    $p['page'] = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $p['debug'] = false;

    $p['total_rows'] = 0;
    $p['max_pages'] = 0;
    $p['offset'] = 0;

    return $p;
}



function ps_paginate(&$p)
{
    $conn = $p['conn'];

    // Original logic assumed SQL returns COUNT value in first column
    $count_result = mysqli_query($conn, $p['sql']);

    if (!$count_result) {
        if ($p['debug']) {
            echo "SQL query failed: " . mysqli_error($conn);
        }
        return false;
    }

    $row = mysqli_fetch_row($count_result);
    $p['total_rows'] = isset($row[0]) ? (int)$row[0] : 0;

    if ($p['total_rows'] == 0) {
        if ($p['debug']) {
            echo "Query returned zero rows.";
        }
        return false;
    }

    $p['max_pages'] = ceil($p['total_rows'] / $p['rows_per_page']);

    if ($p['links_per_page'] > $p['max_pages']) {
        $p['links_per_page'] = $p['max_pages'];
    }

    if ($p['page'] > $p['max_pages'] || $p['page'] <= 0) {
        $p['page'] = 1;
    }

    $p['offset'] = $p['rows_per_page'] * ($p['page'] - 1);

    $data_sql = $p['sql'] . " LIMIT {$p['offset']}, {$p['rows_per_page']}";
    $data_result = mysqli_query($conn, $data_sql);

    if (!$data_result) {
        if ($p['debug']) {
            echo "Pagination query failed: " . mysqli_error($conn);
        }
        return false;
    }

    return $data_result;
}



function renderFirst($p, $tag = 'First')
{
    if ($p['total_rows'] == 0) return false;

    if ($p['page'] == 1) {
        return "<li class='disabled'><a href='javascript:void(0);'> $tag </a></li>";
    }

    return '<li><a href="' . $p['php_self'] . '?page=1&' . $p['append'] . '">' . $tag . '</a></li>';
}

	/**
	 * Display the link to the last page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'
	 * @return string
	 */
function renderLast($p, $tag = 'Last')
{
    if ($p['total_rows'] == 0) return false;

    if ($p['page'] == $p['max_pages']) {
        return "<li class='disabled'><a href='javascript:void(0);'> $tag </a></li>";
    }

    return '<li><a href="' . $p['php_self'] . '?page=' . $p['max_pages'] . '&' . $p['append'] . '">' . $tag . '</a></li>';
}

	
	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string
	 */
function renderNext($p, $tag = '&gt;&gt;')
{
    if ($p['total_rows'] == 0) return false;

    if ($p['page'] < $p['max_pages']) {
        return '<li><a href="' . $p['php_self'] . '?page=' . ($p['page'] + 1) . '&' . $p['append'] . '">' . $tag . '</a></li>';
    }

    return '<li><a id="next" href="javascript:void(0);">'.$tag.'</a></li>';
}


	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
function renderPrev($p, $tag = '&lt;&lt;')
{
    if ($p['total_rows'] == 0) return false;

    if ($p['page'] > 1) {
        return '<li><a href="' . $p['php_self'] . '?page=' . ($p['page'] - 1) . '&' . $p['append'] . '">' . $tag . '</a></li>';
    }

    return '<li><a id="prev" href="javascript:void(0);">'.$tag.'</a></li>';
}


	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
function renderNav($p, $prefix = '<li>', $suffix = '</li>')
{
    if ($p['total_rows'] == 0) return false;

    $batch = ceil($p['page'] / $p['links_per_page']);
    $end = $batch * $p['links_per_page'];

    if ($end > $p['max_pages']) {
        $end = $p['max_pages'];
    }

    $start = $end - $p['links_per_page'] + 1;
    $links = '';

    for ($i = $start; $i <= $end; $i++) {

        if ($i == $p['page']) {
            $links .= str_replace('>', ' class="active">', $prefix)
                    . "<a href='javascript:void(0);'> $i </a>"
                    . $suffix;
        } else {
            $links .= $prefix
                    . '<a href="' . $p['php_self'] . '?page=' . $i . '&' . $p['append'] . '">' . $i . '</a>'
                    . $suffix;
        }
    }

    return $links;
}

function ps_render_full_nav($p)
{
    return '<ul class="pagination">'
        . ps_render_first($p, '&#124;&#60;')
        . ps_render_prev($p)
        . ps_render_nav($p)
        . ps_render_next($p)
        . ps_render_last($p, '&#62;&#124;')
        . '</ul>';
}

function ps_render_boot_nav($p)
{
    return '<ul class="pagination">'
        . ps_render_prev($p, '&laquo;')
        . ps_render_nav($p, '<li>', '</li>')
        . ps_render_next($p, '&raquo;')
        . '</ul>';
}

function ps_set_debug(&$p, $debug)
{
    $p['debug'] = (bool)$debug;
}

?>