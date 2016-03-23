<?php
    
    $homiq_dir=dirname(__FILE__).'/../..';
    require ($homiq_dir.'/db.class.php');
    
    $file=$homiq_dir.'/homiq.ini';
	$ini=parse_ini_file($file,true);
    
    $outputs=[];
    $inputs=[];
    $ios=[];
    
    $adodb=new HDB($ini['database']['type'],$ini['database']['host'], $ini['database']['user'], $ini['database']['pass'], $ini['database']['name']);

    $sql="SELECT * FROM modules WHERE m_active=1";
	$res=$adodb->execute($sql);
    if ($res) for ($i=0;$i<$res->RecordCount();$i++)
    {
        parse_str($adodb->ado_ExplodeName($res,$i));
        
        if ($m_type=='O') {
            $ios[]=[
                'id'=>$m_symbol,
                'device'=>'HQP',
                'address'=>$m_adr,
                'serial'=>$m_serial,
                'name'=>$m_name,
                'active'=>1
            ];
        } elseif ($m_type=='R') {
            $outputs[]=[
                'id'=>$m_symbol,
                'device'=>'HQP',
                'address'=>$m_adr,
                'serial'=>$m_serial,
                'name'=>$m_name,
                'state'=>$m_state,
                'timeout'=>$m_sleep,
                'active'=>1
            ];
        } elseif ($m_type=='I') {
            $outputs[]=[
                'id'=>$m_symbol,
                'device'=>'HQP',
                'address'=>$m_adr,
                'serial'=>$m_serial,
                'name'=>$m_name,
                'state'=>'',
                'active'=>1
            ];
        }
        //echo $adodb->ado_ExplodeName($res,$i);break;
    }
    
    $sql="SELECT * FROM outputs";
	$res=$adodb->execute($sql);
    if ($res) for ($i=0;$i<$res->RecordCount();$i++)
    {
        parse_str($adodb->ado_ExplodeName($res,$i));
        
        $outputs[]=[
            'id'=>$o_symbol,
            'device'=>'HQP',
            'address'=>$o_module.'.'.$o_adr,
            'parent'=>$o_module,
            'name'=>$o_name,
            'state'=>$o_state,
            'timeout'=>$o_sleep,
            'type'=>$o_type,
            'active'=>$o_active
        ];
        //echo $adodb->ado_ExplodeName($res,$i);break;
    }
    
    
    $sql="SELECT * FROM inputs";
	$res=$adodb->execute($sql);
    if ($res) for ($i=0;$i<$res->RecordCount();$i++)
    {
        parse_str($adodb->ado_ExplodeName($res,$i));
        
        $inputs[]=[
            'id'=>$i_symbol,
            'device'=>'HQP',
            'address'=>$i_module.'.'.$i_adr,
            'parent'=>$i_module,
            'name'=>$i_name,
            'state'=>$i_state,
            'type'=>$i_type,
            'active'=>$i_active
        ];
        //echo $adodb->ado_ExplodeName($res,$i);break;
    }
    
    
    
    print_r([$ios,$outputs,$inputs]);