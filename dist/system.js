let page;const system_events={body_left_show:e=>{const t=document.querySelector("section.system-block-body-left");null!=t&&(t.dataset.show=parseInt(t.dataset.show)?0:1)},body_left_type:e=>{const t=document.querySelector("section.system-block-body-left");if(null==t)return;const a=parseInt(t.dataset.min);t.dataset.min=a?0:1,addCookie("is_body_left_min",a?0:1)},tab_show:function(e){const t=e.target,a=t.parentElement,r=parseInt(t.dataset.show);null!=a.querySelector("a[data-selected='1']")&&(isNaN(r)||r)?this.dataset.show=0:this.dataset.show=r?0:1}};let textInputErrorTimer;const textInput=e=>{const t=e.target,a=t.parentElement.parentElement,r=t.dataset.type??t.type??"text",n=t.dataset.wrap??"1",s=t.dataset.force??"1",l=!("0"===n),o=/\n/.test(t.value),u="1"===s;let i=t.dataset.max,c=t.dataset.min;switch(r){case"text":!l&&o&&(t.value=t.value.replace(/\n/g,""),a.dataset.error=1,clearTimeout(textInputErrorTimer),textInputErrorTimer=setTimeout((e=>{a.dataset.error=0}),1e3)),t.nextElementSibling.innerHTML=t.value.replace(/\n/g,"<br>");break;case"account":var m=/[^\w]/g;u&&(t.value=t.value.replace(/\s/g,"").replace(m,""));const e=m.test(t.value);a.dataset.error=e?1:0,a.dataset.message=e?"僅接受半形英文 / 數字 / 底線":"";break;case"number":m=/[^\d\-\.]/g;(u||i||c)&&(t.value=t.value.replace(/\s/g,"").replace(m,"")),a.dataset.error=m.test(t.value)?1:0;break;case"email":(m=/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/).test(t.value)||(a.dataset.error=1,a.dataset.message="內容不符合EMAIL格式.",clearTimeout(textInputErrorTimer),textInputErrorTimer=setTimeout((e=>{a.dataset.error=0,a.dataset.message=""}),1e3));break;case"password":m=/[^\w\!\"\#\$\%\&\'\(\)\*\+\,\-\.\/\:\;\<\=\>\?\@\[\\\]\^\`\{\|\}\~\ ]/;u&&(t.value=t.value.replace(/\s/g,"").replace(m,"")),a.dataset.error=m.test(t.value)?1:0,a.dataset.message=m.test(t.value)?"內容包含不支持的字符.":""}if(null!=i||null!=c)if(i=isNaN(i)?null:parseFloat(i),c=isNaN(c)?null:parseFloat(c),"number"===r){if(/^\-/.test(t.value)&&1===t.value.length||/\.$/.test(t.value)||t.value.length<1)return;t.value=Math.max(c,Math.min(i,parseFloat(t.value)))}else{null!=i&&t.value.length>i&&(t.value=t.value.slice(0,i));var d=null!=c&&t.value.length;"1"===a.dataset.error&&d?a.dataset.message=a.dataset.message+(t.value.length<c?" / 最小長度為 "+c:""):d&&(a.dataset.error=t.value.length<c?1:0,a.dataset.message=t.value.length<c?"最小長度為 "+c:"")}},hasgtagKeyup=e=>{if("Enter"!==e.key)return;const t=e.target;let a=(t.value||"").match(/[#＃\,，\n\ ]+([\w\u4e00-\u9fa5\u3105-\u3129\u31A0-\u31B7\u3040-\u30FF\u3130-\u318F\uAC00-\uD7AF]+)/g)||t.value.split(/\s/),r=new Map;if(a.length<1)return;for(let e=0,t=a[e];e<a.length;e++,t=a[e]){const e=t.replace(/[#＃\,，\n\ ]/g,"").slice(0,24);e.length<2||r.set(e,0)}let n=Array.from(r.keys());n.length>0?(t.value=`#${n.join(" #")} #`.trim(),t.nextElementSibling.innerHTML=t.value.replace(/\n/g,"<br>")):(t.value="#",t.nextElementSibling.innerHTML="#")};function addCookie(e,t,a){if(!{string:1,number:1}[typeof e]||String(e).trim().length<1||null==t)return;e=encodeURIComponent(e),a=1e3*("number"==typeof a?a:3600);const r=Date.now(),n=new Date(r+a);return t="object"==typeof t?JSON.stringify(t).trim():String(t).trim(),t=encodeURIComponent(t),document.cookie=`${e}=${t}; expires=${n.toUTCString()}; path=/;`,document.cookie}function getCookie(e){if(!{string:1,number:1}[typeof e]||String(e).trim().length<1)return;const t=new RegExp("(?:^|; )"+encodeURIComponent(e)+"=([^;]*)"),a=document.cookie.match(t)||[];if(a.length<1)return;let r=a[1];r=decodeURIComponent(r);try{r=JSON.parse(r)}catch(e){return}return r}const keys="abcdefghijklmnopqrstuvwxyz0123456789";let keyMap=new Map;function uniqueID(e=64){let t="";for(let a=0;a<e;a++)t+=keys[_charAt]($Math[_floor](36*$Math[_random]()));return t}