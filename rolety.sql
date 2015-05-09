
DELETE FROM macro WHERE m_symbol LIKE '_R%' OR m_symbol LIKE 'R.%' OR m_symbol IN ('RU','RS','RD');
DELETE FROM macromacro WHERE mm_parent NOT IN (SELECT m_symbol FROM macro);

INSERT INTO macro (m_name,m_symbol,m_sleep,m_val,m_state,m_cmd) VALUES ('_Roleta w górê start','_RUB',0,'u','u','UD');
INSERT INTO macro (m_name,m_symbol,m_sleep,m_val,m_state,m_cmd) VALUES ('_Roleta w górê stop','_RUE',-1,'s','U','UD');
INSERT INTO macro (m_name,m_symbol) VALUES ('Roleta w górê','_RU');

INSERT INTO macro (m_name,m_symbol,m_sleep,m_val,m_state,m_cmd) VALUES ('_Roleta w dó³ start','_RDB',0,'d','d','UD');
INSERT INTO macro (m_name,m_symbol,m_sleep,m_val,m_state,m_cmd) VALUES ('_Roleta w dó³ stop','_RDE',-1,'s','D','UD');
INSERT INTO macro (m_name,m_symbol) VALUES ('Roleta w dó³','_RD');

INSERT INTO macromacro (mm_parent,mm_child,mm_pri) VALUES ('_RD','_RDB',1);
INSERT INTO macromacro (mm_parent,mm_child,mm_pri) VALUES ('_RD','_RDE',2);

INSERT INTO macromacro (mm_parent,mm_child,mm_pri) VALUES ('_RU','_RUB',1);
INSERT INTO macromacro (mm_parent,mm_child,mm_pri) VALUES ('_RU','_RUE',2);


INSERT INTO macro (m_name,m_symbol,m_sleep,m_val,m_state,m_cmd) VALUES ('Roleta stop','_RS',0,'s','','UD');



INSERT INTO macro (m_name,m_symbol,m_master,m_module)
SELECT m_name || ' w dó³',m_symbol||'.D',m_master,m_adr FROM modules WHERE m_type='R' AND m_active=1;
INSERT INTO macromacro (mm_parent,mm_child,mm_pri) SELECT m_symbol||'.D','_RD',1 FROM modules WHERE m_type='R' AND m_active=1; 

INSERT INTO macro (m_name,m_symbol,m_master,m_module)
SELECT m_name || ' w górê',m_symbol||'.U',m_master,m_adr FROM modules WHERE m_type='R' AND m_active=1;
INSERT INTO macromacro (mm_parent,mm_child,mm_pri) SELECT m_symbol||'.U','_RU',1 FROM modules WHERE m_type='R' AND m_active=1; 


INSERT INTO macro (m_name,m_symbol,m_master,m_module)
SELECT m_name || ' stop',m_symbol||'.S',m_master,m_adr FROM modules WHERE m_type='R' AND m_active=1;
INSERT INTO macromacro (mm_parent,mm_child,mm_pri) SELECT m_symbol||'.S','_RS',1 FROM modules WHERE m_type='R' AND m_active=1; 




INSERT INTO macro (m_name,m_symbol,m_group) VALUES ('Rolety w dó³','RD','Dom');
INSERT INTO macro (m_name,m_symbol,m_group) VALUES ('Rolety w górê','RU','Dom');
INSERT INTO macro (m_name,m_symbol) VALUES ('Rolety stop','RS');


INSERT INTO macromacro (mm_parent,mm_child,mm_pri) SELECT 'RU',m_symbol||'.U',1 FROM modules WHERE m_type='R' AND m_active=1; 
INSERT INTO macromacro (mm_parent,mm_child,mm_pri) SELECT 'RD',m_symbol||'.D',1 FROM modules WHERE m_type='R' AND m_active=1; 
INSERT INTO macromacro (mm_parent,mm_child,mm_pri) SELECT 'RS',m_symbol||'.S',1 FROM modules WHERE m_type='R' AND m_active=1; 


