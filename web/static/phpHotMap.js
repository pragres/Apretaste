/**
 * PHP Hot Mapping
 * Hot Mapping of PHP data, functions and methods in JavaScript
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program as the file LICENSE.txt; if not, please see
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt.
 *
 * @author Rafael Rodriguez Ramirez
 * @email rafa@pragres.com
 * @url http:://phphotmap.com
 * @version 1.1
 *
 */
var PHP_HOT_MAP_ACCESS_DENIED_HOST = "PHP_HOT_MAP_ACCESS_DENIED_HOST";
var PHP_HOT_MAP_ACCESS_DENIED_USER = "PHP_HOT_MAP_ACCESS_DENIED_USER";
var PHP_HOT_MAP_LOGIN_SUCCESSFUL = "PHP_HOT_MAP_LOGIN_SUCCESSFUL";
var PHP_HOT_MAP_LOGIN_FAILED = "PHP_HOT_MAP_LOGIN_FAILED";
var PHP_HOT_MAP_LOGOUT_SUCCESSFUL = "PHP_HOT_MAP_LOGOUT_SUCCESSFUL";
var PHP_HOT_MAP_METHOD_EXECUTED = "PHP_HOT_MAP_METHOD_EXECUTED";
var PHP_HOT_MAP_METHOD_NOT_EXISTS = "PHP_HOT_MAP_METHOD_NOT_EXISTS";

/**
 * phpHotMap
 *
 * This is a static class and contain some methods
 * using by phpHotMapClient
 */
var phpHotMap = {

    /**
     * Get a valiXMLHttpRequest object
     */
    getXMLHttpRequestObject: function(){
        var result = false;
        try {
            result = new XMLHttpRequest();
        } 
        catch (e) {
            var XmlHttpVersions = ["MSXML2.XMLHTTP.6.0", "MSXML2.XMLHTTP.5.0", "MSXML2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP", "Microsoft.XMLHTTP"];
            for (var i = 0; i < XmlHttpVersions.length && !result; i++) {
                try {
                    result = new ActiveXObject(XmlHttpVersions[i]);
                } 
                catch (e) {
                }
            }
        }
        return result;
    },
	
	/**
	 * Send ajax request
	 * @param {Object} params
	 */
	ajax: function(params){

		if (typeof params.url == 'undefined'){
			return null;
		}
		
		var xhr = this.getXMLHttpRequestObject();

		params.data = (typeof params.data == 'undefined')?{}:params.data;
		
		xhr.open("POST", encodeURI(params.url), params.async);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

		var s = "";
		var k = 0;
		for(var i in params.data){
			if (k++ > 0) s = s + "&";
			s = s + encodeURIComponent(i) + "=" + encodeURIComponent(params.data[i]);
		}
		
		xhr.send(s);
		
		var result = null;
		
		eval("result = " + xhr.responseText);
		
		return result;
	},
    
    /**
     * Call a remote PHP method
     * @param {Object} server
     * @param {Object} method
     * @param {Object} params
     */
    call: function(server, method, params){
    	var url = '';
    	
    	if (server.indexOf("?")>0) 
    		url = server + "&execute=" + method;
    	else
    		url = 	server + "?execute=" + method;
    	
        var result = this.ajax({
			url: url,
			data: params
		});
		
        return result;
    },
    
    /**
     * Login on server
     * @param {Object} server
     * @param {Object} username
     * @param {Object} password
     */
    login: function(server, username, password){
        var result = this.ajax({
			 url: server + "?login=" + username + "&password=" + password
		});
		
		if (result == null)
		 	return false;
			
        return result.login;
    },
    
    /**
     * Logout on server
     * @param {Object} server
     */
    logout: function(server){
		this.ajax({
			 url: server + "?logout"
		});
    },
	
	str_replace: function(search,replace,subject,count){
		var i=0,j=0,temp='',repl='',sl=0,fl=0,f=[].concat(search),r=[].concat(replace),s=subject,ra=r instanceof Array,sa=s instanceof Array;
		s=[].concat(s);
		if(count){
			this.window[count]=0;
		}
		for(i=0,sl=s.length;i<sl;i++){
			if(s[i]===''){
				continue;
			}
			for(j=0,fl=f.length;j<fl;j++){
				temp=s[i]+'';
				repl=ra?(r[j]!==undefined?r[j]:''):r[0];
				s[i]=(temp).split(f[j]).join(repl);
				if(count&&s[i]!==temp){
					this.window[count]+=(temp.length-s[i].length)/f[j].length;
				}
			}
			}
		return sa?s:s[0];
	}
};

/**
 * Client instance.
 *
 * @param {Object} params
 * 	 - params.server is a string that contain the server address
 *
 * @author Rafael Rodriguez Ramirez
 * @version 1.0
 *
 */
/*
 How to use?
 var client new phpHotMapClient({server: "http://example.com/server.php"});
 var persons = client.Company.getEmployees();
 var companyPhone = client.Company.phone;
 var enterprise = client.getEnterprise();
 */
var phpHotMapClient = function(server){

    // Call to server for retrieving the PHP mapping
	var methods = phpHotMap.ajax({
		url: server
	});
	
    // Add methods to this instance
    for (m in methods) {
	
		if (m.indexOf('.') >= 0){
			var parts = null;
			eval('parts = ["' + phpHotMap.str_replace('.', '","', m) + '"];');
			var v = '';
			for(var i in parts){
				v = '';
				for(var j in parts){
					if (j<=i) v += (v!=''?'.':'') + parts[j];
				}
				eval("if (typeof " + v + " == 'undefined') " + v + " = {};");
				if (methods[m] != "function") if (i<parts.length-1) eval(v + ".__server = server;");
			}
			eval(v + " = methods[m];");
		} else {
			if (methods[m] != "function") methods[m].__server = server;
			eval("this." + m + " = methods." + m + ";");
		}
    };
    
    // Add some necessary properties and methods
    
    /* Server address */
    this.__server = server;
    
    /* Login on server */
    this.__login = function(username, password){
        return phpHotMap.login(this.__server, username, password);
    }
    
    /* Logout on server */
    this.__logout = function(){
        phpHotMap.logout(this.__server);
    }
};
