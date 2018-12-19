 

import {currentUser} from '#/main/core/user/current'
import {PMHOST as pmlabhost} from '&/mindmecn/markdown-bundle/resources/constants'

 /**
         * content为Markdown文本 htmlcontent为json字符串，处理逻辑在JS代码中
         * json[0]为ymal串，解析后为工作流调用信息
         * 
         * 正则表达式
         * var str="<div data-markdown><textarea data-text>***<tr>kjk</tr></div></textarea>";
         *
         * 单元格例：<section data-markdown><textarea data-template>
         * ## Page title
         * A paragraph with some text and a [link](http://hakim.se).
         * </textarea></section>
         *
         * js:str.match(/<section data-markdown><textarea data-template>([\s\S]*)<\/textarea><\/section>/)[1]);
         *
         *
         * 行例：<section class='md-markdown-row'>
         * <section data-markdown class='md-markdown-cell'><textarea data-template>
         * ## Page title
         * A paragraph with some text and a [link](http://hakim.se).
         * </textarea></section>
         * <section data-markdown class='md-markdown-cell'><textarea data-template>
         * ## Page title
         * A paragraph with some text and a [link](http://hakim.se).
         * </textarea></section></section>
         * ps: 最后一行结束为行和单元格结尾之和
         *
         *  js:str.match(/<section class=\'md-markdown-cell\'>([\s\S]*)<\/textarea><\/section><\/section>/)[1]);
         * */

 //检查fetch状态
 function checkStatus(response) {
  if (response.status >= 200 && response.status < 300) {
    return response
  } else {
    var error = new Error(response.statusText)
    error.response = response
    throw error
  }
}



function convertToHContent(rows){
     //将表格中数据排序后，组合为json格式，存入数据库中
    for (const prop in rows) {
         rows[prop].cellid=prop;
    }
    return JSON.stringify(rows);
}


function convertToContent(rows){
     //将json数据转换为markdown数组
      let rowStr = '';
      for (const prop in rows) {
      if ((rows[prop].content.trim() != null) && (rows[prop].content.trim() != '')){
       //rowStr += rows[prop].content + '\n<!--mdcell-->\n';
       if (prop==0){
           rowStr = converntCellToMarkdown(rows[prop].content,"content",prop) + "\n";
       }else{
       rowStr += "<section class='md-markdown-row'>\n" 
               + converntCellToMarkdown(rows[prop].content,"content",prop) + "\n"
               + converntCellToMarkdown(rows[prop].desc,"desc",prop) + "\n"
               + converntCellToMarkdown(rows[prop].syntax,"syntax",prop) + "\n"
               + converntCellToMarkdown(rows[prop].option,"option",prop) + 
               "</section>"  + "\n<!--mdcell-->\n";
        }
       }
      }
    return rowStr;
}

function converntCellToMarkdown(mkStr,cellName,rowNum){
  let cellStr = "<section id='md-lab-" + cellName + rowNum.toString() +
        "' data-markdown class='md-markdown-cell'><textarea data-template>\n"
        + mkStr +"\n" +
        "</textarea></section>";
    return cellStr;
}
  
function convertHcontentToData(hcontent){
    //将数据库中提取数据转换为表格中json数据
    if (hcontent=="undefine" || !hcontent){    
     return    null;
    }
    return JSON.parse(hcontent);
}

function convertContentToData(content){
    //将数据库中提取数据转换为表格中json数据 
   if (content=="undefine" || !content ){    
     return    null;
    }
    let dataJson = [] ;
    let strs=content.split("<!--mdcell-->"); //字符分割
    for (let i=0;i<strs.length ;i++ )
   { 
       var varJson = {
           "cellid": i+1,
           "content": strs[i]
       }
       dataJson.push(varJson) ;
   }
   return dataJson;
}

export {
  convertToContent,
  convertToHContent,
  convertContentToData,
  convertHcontentToData,
  checkStatus,
  parseJSON
     } 
 