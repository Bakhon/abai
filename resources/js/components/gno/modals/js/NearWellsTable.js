import {pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions} from '@store/helpers';

export default {
    name: 'near-wells',
    data: function() {
        return {
        };
    },
    computed: {
        ...pgnoMapState([
            'wellAnalysis',
            'nearWells'
        ]),
    }
}