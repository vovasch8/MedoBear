import RangeSliderPips from "https://cdn.skypack.dev/svelte-range-slider-pips@2.2.2";

let vals = [0, 3000];
let timer;

const $slider = document.getElementById("slider");

const currency = new Intl.NumberFormat("ua", {
    style: "currency",
    currency: "UAH",
    maximumFractionDigits: 0
});

const formatter = (value) => currency.format(value);

const stop = () => {
    const $slider = document.querySelector("#PriceGradient");
    $slider.classList.remove("up", "down");
};

const slide = (e) => {
    const $slider = document.querySelector("#PriceGradient");
    const delta = -(e.detail.previousValue - e.detail.value);
    if (delta > 0) {
        $slider.classList.add("up");
        $slider.classList.remove("down");
    } else {
        $slider.classList.add("down");
        $slider.classList.remove("up");
    }
    clearTimeout(timer);
    timer = setTimeout(stop, 66);
};

const slider = new RangeSliderPips({
    target: $slider,
    props: {
        id: "PriceGradient",
        min: 0,
        max: 3000,
        values: vals,
        step: 10,
        pips: false,
        range: true,
        float: true,
        formatter: formatter
    }
});

slider.$on('change', slide);
slider.$on('stop', stop);

setTimeout(() => {
    document.querySelector("#PriceGradient .rangeHandle").focus()
}, 1000 );
