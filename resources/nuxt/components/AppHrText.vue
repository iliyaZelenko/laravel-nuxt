<template>
  <div class="hr-sect">
    <span class="subheading">
      {{ text }}
    </span>
  </div>
</template>

<script>
export default {
  props: ['text']
}
</script>

<style scoped>
.hr-sect {
  display: flex;
  flex-basis: 100%;
  align-items: center;
  color: rgba(0, 0, 0, 0.35);
  margin: 28px 0px;
}
.hr-sect::before,
.hr-sect::after {
  content: "";
  flex-grow: 1;
  /* background: rgba(0, 0, 0, 0.35); */

  height: 1px;
  font-size: 0px;
  line-height: 0px;
  margin: 0px 8px;
}

/* Сам добавил */
.hr-sect::before {
  /* rgba(128, 128, 128, 0.85) */
  background: -webkit-gradient(linear, 0 0, 100% 100, from(white), to(white), color-stop(50%, gray));
}
.hr-sect::after {
  background: -webkit-gradient(linear, 0 100, 100% 0, from(white), to(white), color-stop(50%, gray));
}
</style>

<!-- .hr-text {
  line-height: 1em;
  position: relative;
  outline: 0;
  border: 0;
  color: black;
  text-align: center;
  height: 1.5em;
  opacity: .5;
  &:before {
    content: '';
    /* use the linear-gradient for the fading effect
       use a solid background color for a solid bar */
    background: linear-gradient(to right, transparent, #818078, transparent);
    position: absolute;
    left: 0;
    top: 50%;
    width: 100%;
    height: 1px;
  }
  &:after {
    content: attr(data-content);
    position: relative;
    display: inline-block;
    color: black;

    padding: 0 .5em;
    line-height: 1.5em;
    /* this is really the only tricky part, you need to specify the background color of the container element... */
    color: #818078;
    /* background-color: #fcfcfa; */
  }
} -->
