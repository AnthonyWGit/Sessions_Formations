SELECT * FROM module_session
WHERE module_session.id NOT IN 
(SELECT module_session.id FROM module_session
LEFT JOIN programme ON programme.module_session_id = module_session.id
LEFT JOIN session ON programme.session_id = session.id
WHERE session.id = 3 )

sql finding modules not in session