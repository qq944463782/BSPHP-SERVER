<?php


/***********************接口介绍说明******************************************
* BSphpSeSsL.in  
* 获取BSphpSeSsL
* 等于session/cookies/token 一样定义，名字不一样而已
* *****************************************************************************
*/


//开启Session，。in接口默认不开,需要手动开
Plug_Session_Appen_Open('NEWSESSION');
Plug_Echo_Info(session_id(),1000);