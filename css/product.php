<style>
.bggrey{
  width: 100%;
  background-color: #F6F6F6;
}
.text_title{
  font-size: 16px;
  font-weight: bold;
}
.product_title{
margin: auto;
width:100%;
height: 35px;
color:white;
font-weight: bold;
padding: 5px;
background-color: #18A0FB;
/* border: 1px,solid,transparent; */
border-radius: 5px 5px 0 0;
}
.product_title span{
  background-color: #00bf63;
  border-radius: 5px;
  padding:0 10px 0 10px ;
}


.product_content{
margin: auto;
width:100%;
height: auto;
padding-bottom: 20px;
padding-left: 15px;
/* border: 1px solid black; */
border-radius:  0 0 5px 5px;
box-shadow: black;
background-color: white;
}

.product_content p{
  font-size: 16px;
  font-weight: bold;
  margin-top: 5px;
  margin-bottom: 0;
  padding-bottom: 0;
  /* margin-bottom: 5px; */
}
.product_content button{
  font-size: 14px;
padding: 0 20px 0 20px;
margin-top: 0px;
}
.product_content table{
  margin: auto;
  width: 98%;
  border-radius: 5px;
}

/* 頁籤 */
.tab_css{display:flex;flex-wrap:wrap;padding: 5px;}
.tab_css input{display:none}
.tab_css > .tab_content input{display:block}
#tag{margin: 0 5px 5px 25px;}
.tab_css label{margin: 0 5px 5px 0; padding: 10px 16px; cursor: pointer; border-radius: 5px; background: #999; color: #fff; opacity: 0.5;}
.tab_content{order:1;display: none; width:100%;line-height: 1.6; font-size: .9em; padding: 5px;}
.tab_css input:checked + label, .tab_css label:hover{opacity: 1; font-weight:bold;}
.tab_css input:checked + label + .tab_content{display: initial;}
.tab_content>.btn{height: 40px;margin-left: 30px;font-size: 16px; font-weight: bold;}
.tab_content > .table > tbody > tr > td > div > a{
  cursor:pointer;
  color:#007bff;
  font-weight: 600;
}

td > div>button.btnsave,td > div>.btndel , td > div>.btnsadd, td > div > .btncnl{
  color:#007bff;
  padding: 5px 5px 0 5px;
  background-color: #f6f6f600;
  border: #f6f6f600;
}
</style>
<body>