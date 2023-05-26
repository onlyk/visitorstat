local cjson = require "cjson"
local dict = ngx.shared.ourcache

local function getStats()
	local redis = require "resty.redis"
	local red = redis:new()
	red:set_timeouts(1000, 1000, 1000) -- 1 sec

    local ok, err = red:connect("redis", 6379)

    if not ok then
    	ngx.say("failed to connect: ", err)
    	return
    end

    stats, err = red:hgetall("stat")
    if not stats then
    	ngx.say("failed to fetch: ", err)
    	return
    end

    return stats
end

if not dict then
	ngx.say("No dictionary specified")
end

cachedStats = dict:get('stat');
if not cachedStats then
	local stats = getStats()
	dict:set('stat', cjson.encode(stats), 5)
	ngx.say(cjson.encode(stats))
	return
end

ngx.say(cachedStats)




