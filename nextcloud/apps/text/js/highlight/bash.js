(window.textWebpackJsonp=window.textWebpackJsonp||[]).push([[19],{425:function(e,n,s){"use strict";function t(e){return e?"string"==typeof e?e:e.source:null}function a(){for(var e=arguments.length,n=new Array(e),s=0;s<e;s++)n[s]=arguments[s];var a=n.map((function(e){return t(e)})).join("");return a}e.exports=function(e){var n={},s={begin:/\$\{/,end:/\}/,contains:["self",{begin:/:-/,contains:[n]}]};Object.assign(n,{className:"variable",variants:[{begin:a(/\$[\w\d#@][\w\d_]*/,"(?![\\w\\d])(?![$])")},s]});var t={className:"subst",begin:/\$\(/,end:/\)/,contains:[e.BACKSLASH_ESCAPE]},i={begin:/<<-?\s*(?=\w+)/,starts:{contains:[e.END_SAME_AS_BEGIN({begin:/(\w+)/,end:/(\w+)/,className:"string"})]}},o={className:"string",begin:/"/,end:/"/,contains:[e.BACKSLASH_ESCAPE,n,t]};t.contains.push(o);var c={begin:/\$\(\(/,end:/\)\)/,contains:[{begin:/\d+#[0-9a-f]+/,className:"number"},e.NUMBER_MODE,n]},r=e.SHEBANG({binary:"(".concat(["fish","bash","zsh","sh","csh","ksh","tcsh","dash","scsh"].join("|"),")"),relevance:10}),l={className:"function",begin:/\w[\w\d_]*\s*\(\s*\)\s*\{/,returnBegin:!0,contains:[e.inherit(e.TITLE_MODE,{begin:/\w[\w\d_]*/})],relevance:0};return{name:"Bash",aliases:["sh","zsh"],keywords:{$pattern:/\b[a-z._-]+\b/,keyword:"if then else elif fi for while in do done case esac function",literal:"true false",built_in:"break cd continue eval exec exit export getopts hash pwd readonly return shift test times trap umask unset alias bind builtin caller command declare echo enable help let local logout mapfile printf read readarray source type typeset ulimit unalias set shopt autoload bg bindkey bye cap chdir clone comparguments compcall compctl compdescribe compfiles compgroups compquote comptags comptry compvalues dirs disable disown echotc echoti emulate fc fg float functions getcap getln history integer jobs kill limit log noglob popd print pushd pushln rehash sched setcap setopt stat suspend ttyctl unfunction unhash unlimit unsetopt vared wait whence where which zcompile zformat zftp zle zmodload zparseopts zprof zpty zregexparse zsocket zstyle ztcp"},contains:[r,e.SHEBANG(),l,c,e.HASH_COMMENT_MODE,i,o,{className:"",begin:/\\"/},{className:"string",begin:/'/,end:/'/},n]}}}}]);
//# sourceMappingURL=bash.js.map?v=c6a4e5de7e95487150c4