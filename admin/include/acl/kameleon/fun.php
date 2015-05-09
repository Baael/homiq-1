<?php

	function acl_treeArray($page,$tree)
	{
		$right_page_tree=array($page);
		$t=substr($tree,1,strlen($tree)-2);
		if (strlen($t)) foreach (explode(':',$t) AS $p) $right_page_tree[]="$p+";

		return $right_page_tree;
	}


	function acl_hasRight($id,$right,$resource,$tree='')
	{
		if (!strlen($tree)) $tree=$_SERVER['tree'];
		if (!strlen($tree)) $tree=$_SERVER['WEBPAGE']->tree;


		return $_SERVER['acl']->hasRight($right, $resource, acl_treeArray($id,$tree) );
	}

	function acl_hasPageRight($page,$right,$tree='')
	{
		return acl_hasRight($page,$right,PAGE_RESOURCE,$tree='');
	}

	function acl_Page($page,$tree='')
	{
		return acl_hasPageRight($page,PAGE_VISIT_RIGHT,$tree);
	}

