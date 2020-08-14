/**
 * Send HTTP request using jQuery Ajax API.
 */

function http(uri, data, complete)
{
    uri = uri.split('?')[0];

    var uriToArray = function(uri)
        {
            if(uri.substring(0, 1) === '/')
            {
                uri = uri.substring(1, uri.length);
            }

            return uri.split('/');
        },
        uri1 = uriToArray(uri),
        route = null;

    if(routes.length > 0)
    {
        for(i = 0; i <= (routes.length - 1); i++)
        {
            var uri2 = uriToArray(routes[i].uri),
                n = 0;

            if(uri1.length === uri2.length)
            {
                for(y = 0; y <= (uri2.length - 1); y++)
                {
                    if(uri1[y] === uri2[y])
                    {
                        n++;
                    }
                    else
                    {
                        var length = uri2[y].length;
                        if(uri2[y].substring(0, 1) === '{' && uri2[y].substring(length - 1, length) === '}')
                        {
                            n++;
                        }
                    }
                }
            }

            if(n === uri2.length && uri1.length === uri2.length)
            {
                route = routes[i];
                break;
            }
        }
    }

    if(route !== null)
    {
        $.ajax({

            url: url(uri),

            type: route.type,

            data: data,

            dataType: route.dataType,

            cache: route.cache,

            success: function(data)
            {
                if(complete)
                {
                    complete(data);
                }
            }

        });
    }
}

/**
 * Merge global component object to local 
 * component object.
 */

function extendUtil(id, object)
{
    return $.extend(object, {

        /**
         * Return component id.
         */

        id: function()
        {
            return id;
        },

        /**
         * Return component jquery object. 
         */

        el: function(id)
        {
            return $('#' + id);
        },

        /**
         * Set outer style display of component to block.
         */

        show: function()
        {
            this.el(id).show();
        },

        /**
         * Set outer style display of component to none.
         */

        hide: function()
        {
            this.el(id).hide();
        }

    });
}