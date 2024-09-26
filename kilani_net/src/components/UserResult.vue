<script>

export default {
  

  props: {
    msg: {
      type: Function,
      required: true
    },
    details:{
      type:String,
      required:true
    }
  },
};
</script>
<template>
    <div
      class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
      role="alert"
    >
      <strong class="font-bold">Warning! </strong>
      <span class="block sm:inline">{{details}}</span>
      <span
        @click="msg"
        class="absolute top-0 bottom-0 right-0 px-4 py-3"
      >
        <svg
          class="fill-current h-6 w-6 text-red-500"
          role="button"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
        >
          <title>Close</title>
          <path
            d="M14.348 5.652a.5.5 0 010 .707L10.707 10l3.641 3.641a.5.5 0 01-.707.707L10 10.707l-3.641 3.641a.5.5 0 01-.707-.707L9.293 10 5.652 6.359a.5.5 0 01.707-.707L10 9.293l3.641-3.641a.5.5 0 01.707 0z"
          />
        </svg>
      </span>
    </div>
</template>