<?php
if(!empty($_GET['route'])){
	$route = trim(htmlspecialchars(strip_tags($_GET['route'])));
	$rt=explode('/',$route);
	$rtn=count($rt);
	switch($rtn){
		case 1:
			if($rt[0] == 'search'){
				$query = array(
					'class'=>'Search',
					'template'=>'search'
				);
			}else if($rt[0] == 'ua' || $rt[0] == 'ru'){
				$query = array(
					'class'=>'MainPage',
					'template'=>'main-page',
					'region'=>$rt[0]
				);
			}else if($rt[0] == 'discounts' || $rt[0] == 'shops' || $rt[0] == 'shop' || $rt[0] == 'cabinet' || $rt[0] == 'logout'){
				$query = array(
					'class'=>ucfirst($rt[0]),
					'template'=>$rt[0],
					'alias'=>''
				);
			}else{
				$query = array(
					'class'=>'Page',
					'template'=>'page',
					'alias'=>$rt[0]
				);
			}
		break;
		
		case 2:
			if($rt[1] == 'ua' || $rt[1] == 'ru'){
				$query = array(
					'class'=>ucfirst($rt[0]),
					'template'=>$rt[0],
					'alias'=>'',
					'region'=>$rt[1]
				);
			}elseif($rt[0] == 'discounts' || $rt[0] == 'shops' || $rt[0] == 'shop' || $rt[0] == 'cabinet'){
				$query = array(
					'class'=>ucfirst($rt[0]),
					'template'=>$rt[0],
					'alias'=>$rt[1]
				);
			}else{
				$query = array(
					'class'=>'Page',
					'template'=>'page',
					'alias'=>$rt[1]
				);
			}
		break;
		
		case 3:
			if($rt[0] == 'search' && $rt[1] == 'page'){
				$query = array(
					'class'=>'Search',
					'template'=>'search',
					'page'=>$rt[2]
				);
			}elseif($rt[1] == 'page'){			
				$query = array(
					'class'=>ucfirst($rt[0]),
					'template'=>$rt[0],
					'alias'=>'',
					'page'=>$rt[2]
				);
			}elseif($rt[0] == 'go'){
				$query = array(
					'class'=>ucfirst($rt[0]),
					'template'=>$rt[0],
					'alias'=>'',
					'units'=>$rt[1],
					'id'=>$rt[2]
				);
			}
		break;
		
		case 4:
			if($rt[2] == 'page'){
				$query = array(
					'class'=>ucfirst($rt[0]),
					'template'=>$rt[0],
					'alias'=>$rt[1],
					'page'=>$rt[3]
				);
			}
		break;
	}
}else{
	$query = array(
		'class'=>'MainPage',
		'template'=>'main-page'
	);
}

$query = array_merge($query, array('route' => $route));