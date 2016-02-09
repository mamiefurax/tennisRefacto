##
## Set info to access backend nginx server
backend default {
    .host = "nginx-stack";
    .port = "80";
}

##
## Cache only content with no cookies
sub vcl_recv {
    set req.http.Surrogate-Capability = "abc=ESI/1.0";

    if (req.http.X-Forwarded-Proto == "https" ) {
        set req.http.X-Forwarded-Port = "443";
    }
    else {
        set req.http.X-Forwarded-Port = "80";
    }

    //Remove cookie for GET Requests
    if (req.request == "GET") {
        remove req.http.cookie;
    }

    // Remove all cookies except the session ID.
    if (req.http.Cookie) {
        set req.http.Cookie = ";" + req.http.Cookie;
        set req.http.Cookie = regsuball(req.http.Cookie, "; +", ";");
        set req.http.Cookie = regsuball(req.http.Cookie, ";(PHPSESSID)=", "; \1=");
        set req.http.Cookie = regsuball(req.http.Cookie, ";[^ ][^;]*", "");
        set req.http.Cookie = regsuball(req.http.Cookie, "^[; ]+|[; ]+$", "");

        if (req.http.Cookie == "") {
            // If there are no more cookies, remove the header to get page cached.
            remove req.http.Cookie;
        }
    }
}

sub vcl_fetch {
    if (beresp.http.Surrogate-Control ~ "ESI/1.0") {
        unset beresp.http.Surrogate-Control;
        set beresp.do_esi = true;
    }

    /* By default, Varnish3 ignores Cache-Control: no-cache and private
       https://www.varnish-cache.org/docs/3.0/tutorial/increasing_your_hitrate.html#cache-control
    */

    if (beresp.http.Cache-Control ~ "private" ||
        beresp.http.Cache-Control ~ "no-cache" ||
        beresp.http.Cache-Control ~ "no-store"
    ) {
        return (hit_for_pass);
    }
}


sub vcl_miss {
    	if (req.request == "PURGE") {
        	error 404 "Not purged";
    	}
}

sub vcl_hit {
	  if (req.request == "PURGE") {
	    	purge;
	    	error 200 "Purged.";
	  }
}

##
## Some error reporting for DEV env only.
sub vcl_error {
      	set obj.http.Content-Type = "text/html; charset=utf-8";
      	set obj.http.Retry-After = "5";
      	synthetic {"
  <?xml version="1.0" encoding="utf-8"?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html>
    <head>
      <title>"} + obj.status + " " + obj.response + {"</title>
    </head>
    <body>
      <h1>Error "} + obj.status + " " + obj.response + {"</h1>
      <p>"} + obj.response + {"</p>
      <h3>Guru Meditation:</h3>
      <p>XID: "} + req.xid + {"</p>
      <hr>
      <p>Varnish cache server</p>
    </body>
  </html>
  "};
	return (deliver);
}