process.php 2017/1/17版本是针对新网站(http://www.ciweek.com/list-1.shtml)的抓取的脚本。且keywords和description未抓取成功，因为新网站用了<meta name="keywords" content="{$SEO['keyword']}">
<meta name="description" content="{$SEO['description']}">

process0110final.php是老网站的最终版本http://ciweek.com/v7/list.jsp 且抓取的网页数据放到同一个文件里y.html

process1.php和process25.php是针对http://ciweek.com/v7/list.jsp抓取的，本人觉得比
process0110final.php靠谱
以上都是用file_get_contents和phpQuery来实现的

processcurl.php是用curl方式抓取的,

抓取全部的500条数据