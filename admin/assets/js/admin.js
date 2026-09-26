(function(){
    'use strict';
    document.addEventListener('click',function(e){
        var button=e.target.closest('[data-ndsoft-copy-report]');
        if(!button){return;}
        var textarea=document.getElementById('ndsoft-aiwd-report');
        if(!textarea){return;}
        var copied=function(){var old=button.textContent;button.textContent='Copied';setTimeout(function(){button.textContent=old;},1200);};
        if(navigator.clipboard&&navigator.clipboard.writeText){navigator.clipboard.writeText(textarea.value).then(copied);return;}
        textarea.focus();textarea.select();
        try{document.execCommand('copy');copied();}catch(err){}
    });
}());
