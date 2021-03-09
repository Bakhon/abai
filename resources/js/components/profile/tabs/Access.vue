<template>
   <div class="mainAccessBlock">
            <div class="accessMenu">
              <ul>
                <li v-for="(tab, code) in access"
                :class="{'active': accessTab === code}"
                @click="accessTab = code">
                  <a href="#">
                  <span v-html="tab.ico"></span>
                  <span>{{tab.name}}</span>
                  </a>
                </li>
              </ul>
            </div>
            <div class="accessContent">
              <div class="mainBlock" v-if="accessTab === 'open'">
                    <open-access-profile></open-access-profile>
              </div>
              <div class="mainBlock" v-else-if="accessTab === 'library'">
                    <library-access-profile></library-access-profile>
              </div>
              <div class="mainBlock" v-else-if="accessTab === 'history'">
                  <history-access-profile></history-access-profile>
              </div>
            </div>
          </div>
</template>

<script>
import params from '../../../json/profile.json'
import OpenAccessProfile from './access-tabs/OpenAccess'
import LibraryAccessProfile from './access-tabs/LibraryAccess'
import HistoryAccessProfile from './access-tabs/HistoryAccess'


export default {
  name: 'AccessProfile',
  props: {
  },
  components: {
      OpenAccessProfile,
      LibraryAccessProfile,
      HistoryAccessProfile
      },
  data() {
    return {
        access: params.access,
        accessTab: 'open'
    }
  },
  methods: {}
}
</script>