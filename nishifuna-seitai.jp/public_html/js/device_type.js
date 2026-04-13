var DevSwitch = {
    /**
     * プロパティ
     **/
    "SP" : 1,                 //SPサイトFLG
    "PC" : 0,                 //PCサイトFLG
    "DAYS" : 730,             //Cookie：保存期間[2年]
    "ROOTPATH":"/",           //Cookie：Path
    "DEVICE" : "device_name", //Cookie：KeyName
    
    /**
     * _getUserAgent 
     * デバイス判定
     * Param:
     * return：
     *        SP: 1
     *        PC: 0
     */
    "_getUserAgent" : function(){
        if (navigator.userAgent.indexOf('iPhone') > 0 || navigator.userAgent.indexOf('iPod') > 0 || navigator.userAgent.indexOf('Android') > 0) {
            return this.SP;
        }
        return this.PC;
    },

    /**
     * _setCookie 
     * Cookie値セット
     * Param:
     *        key_value:保存値[SP=1,PC=0]
     * return：
     *        
     */
    "_setCookie" : function(key_value){
         $.cookie(this.DEVICE, key_value, {path:this.ROOTPATH, expires:this.DAYS} );
    },

    /**
     * _getCookie 
     * Cookie値取得
     * Param:
     *        key_name:KEY名
     * return：
     *        str:文字列
     */
    "_getCookie" : function(key_name){
        return $.cookie(key_name);
    },
    
    /**
     * _refresh 
     * リフレッシュとして使用
     * Param:
     *        url:絶対パス
     * return：
     *        
     */
    "_refresh":function(url){
        location.href=url;
    },

    /**
     * _viewPc 
     * PCページ処理
     * Param:
     *        url: リダイレクト先
     * return：
     *        
     */
    "_viewPc" : function(url){
        //value=null
        if(this._getCookie(this.DEVICE)==null){
               this._refresh(url);
        }
        //value=sp
        if(this._getCookie(this.DEVICE)==this.SP){
               this._refresh(url);
        }
    },
  
     /**
     * switchView 
     * Main処理
     * Param:
     *        url: リダイレクト先URL
     * return：
     *        
     */
    "switchView":function(url){
        //UA判定
        if(this._getUserAgent()==this.PC){
            return false;
        }
        //PCページ表示
        this._viewPc(url);
        //リンクボタン表示
        $("#device_switch_btn").show();
    },

     /**
     * setLink 
     * LinkActive：SPページへ
     * Param:
     *        url: Link先URL
     * return：
     *        
     */  
    "setLink" : function(url){
        this._setCookie(this.SP);
        this._refresh(url);
    }

};

