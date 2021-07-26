import {mapActions, mapGetters, mapMutations, mapState,} from 'vuex';

// Gu Map //
export const guMapState = arrNames => ({
    ...mapState('guMap', [
        ...arrNames,
    ]),
});

export const guMapGetters = arrNames => ({
    ...mapGetters('guMap', [
        ...arrNames,
    ]),
});

export const guMapMutations = arrNames => ({
    ...mapMutations('guMap', [
        ...arrNames,
    ]),
});

export const guMapActions = arrNames => ({
    ...mapActions('guMap', [
        ...arrNames,
    ]),
});
// End Gu Map //

// bd Form State //
export const bdFormState = arrNames => ({
    ...mapState('bdform', [
        ...arrNames,
    ]),
});

export const bdFormActions = arrNames => ({
    ...mapActions('bdform', [
        ...arrNames,
    ]),
});
// End bd Form //

// dzoMap //
export const dzoMapState = arrNames => ({
    ...mapState('dzoMap', [
        ...arrNames,
    ]),
});

export const dzoMapActions = arrNames => ({
    ...mapActions('dzoMap', [
        ...arrNames,
    ]),
});
// End dzoMap //


// complication Monitoring //
export const complicationMonitoringState = arrNames => ({
    ...mapState('complicationMonitoring', [
        ...arrNames,
    ]),
});

export const complicationMonitoringMutations = arrNames => ({
    ...mapMutations('complicationMonitoring', [
        ...arrNames,
    ]),
});

export const complicationMonitoringActions = arrNames => ({
    ...mapActions('complicationMonitoring', [
        ...arrNames,
    ]),
});
// End complication Monitoring //


// paegtm Map //
export const paegtmMapActions = arrNames => ({
    ...mapActions('paegtmMap', [
        ...arrNames,
    ]),
});

export const paegtmMapGetters = arrNames => ({
    ...mapGetters('paegtmMap', [
        ...arrNames,
    ]),
});
// End paegtm Map //


// pgno Map //
export const pgnoMapMutations = arrNames => ({
    ...mapMutations('pgno', [
        ...arrNames,
    ]),
});

export const pgnoMapActions = arrNames => ({
    ...mapActions('pgno', [
        ...arrNames,
    ]),
});
// End pgno Map //


// global loading //
export const globalloadingState = arrNames => ({
    ...mapState('globalloading', [
        ...arrNames,
    ]),
});

export const globalloadingMutations = arrNames => ({
    ...mapMutations('globalloading', [
        ...arrNames,
    ]),
});
// End global loading //