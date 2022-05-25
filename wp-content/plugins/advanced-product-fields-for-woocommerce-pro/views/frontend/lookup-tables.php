<script>

	WAPF.Filter.add('wapf/fx/functions', function(f) {
	    f.push('lookuptable');
	    return f;
	});

	WAPF.Filter.add('wapf/fx/solve', function(solution,data) {

	    if(data.func === 'lookuptable') {

            function findNearest(value,axis) {
                if(axis[''+value])
                    return value;
                var keys = Object.keys(axis);
                value = parseFloat(value);
                if(value < parseFloat(keys[0]))
                    return keys[0];
                for(var i=0; i < keys.length; i++ ) {
                    if(value > parseFloat(keys[i]) && value <= parseFloat(keys[i+1]))
                        return keys[i+1];
                }
                // return last
                return keys[i];
            }

	        var lookuptable = wapf_lookup_tables[data.args[0]];
	        var tableValues = [], prev = lookuptable;

	        for(var i = 1; i < data.args.length; i++) {
	            var v = WAPF.Util.getFieldValue(jQuery('[data-field-id="'+data.args[i]+'"]'));
	            if(v == '') return 0;
                var n = findNearest(v,prev);
                tableValues.push(n);
                prev = prev[n];
            }

            return tableValues.reduce(function(acc,curr){
                return acc[curr];
            },lookuptable);

        }

	    return solution;
	});
</script>