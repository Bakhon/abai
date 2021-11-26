<template>
  <div class="faq-page">
    <div class="faq-page__inner">
      <div class="faq-page__search">
        <input placeholder="Опишите проблему" type="text" v-model="query" />
        <button>
          <span>Поиск</span>
        </button>
      </div>
      <div class="faq-blocks-holder">
        <faqPageModuleBlock
          v-for="(block, index) in filteredBlocks"
          :key="index"
          :block="block"
        />
      </div>
    </div>
  </div>
</template>

<script>
import faqPageModuleBlock from "./faqPageModuleBlock";

export default {
  name: "main-page",
  components: {
    faqPageModuleBlock,
  },
  data() {
    return {
      query: "",
      blocks: [
        {
          id: 1,
          question: 'Как зарегистрироваться в ИС "ABAI"?', 
          answer: 'Для регистрации в ИС "ABAI" сотрудникам АО "НК "КазМунайГаз" или ТОО "КМГ Инжиниринг" требуется использовать учетные записи, использумые для разблокироваки рабочего компьютера.',      
        },
        {
          id: 2,
          question: 'Как получить логин и пароль для входа в ИС "ABAI"?', 
          answer: 'В случае, если Вы не являетесь сотрудником АО "НК "КазМунайГаз" или ТОО "КМГ Инжиниринг", Вам нужно написать письмо .......',      
        },
        {
          id: 3,
          question: 'Почему кнопки в модуле не активны?', 
          answer: 'Попробуйте перезагрузить страницу используя клавиши Ctrl + F5, если проблема не устранилась, проверьте заполненность полей или уровень доступа на модуль',      
        },
        {
          question: 'Как получить доступ к модулю?', 
          answer: 'Обратитесь к Product Owner нужного Вам модуля',      
        },        
      ],
    };
  },
  computed: {
    filteredBlocks() {
      if (this.query.length > 0) {
        return this.blocks.filter((block) => {
          return (
            block.question.toLowerCase().indexOf(this.query.toLowerCase()) > -1
          );
        });
      }
      return this.blocks;
    },
  },
};
</script>