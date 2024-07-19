/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */window.addEventListener("DOMContentLoaded",c=>{const t=document.body.querySelector("#sidebarToggle");t&&t.addEventListener("click",d=>{d.preventDefault(),document.body.classList.toggle("sb-sidenav-toggled"),localStorage.setItem("sb|sidebar-toggle",document.body.classList.contains("sb-sidenav-toggled"))})});setTimeout(function(){$(".preload").css("display","none"),$(".content-body").css("display","none")},1200);$(document).ready(function(){$(".btn-order-products").click(function(c){$(".modal-body").html(`<div class='d-flex justify-content-center w-100'><div class="spinner-border p-5" role="status">
  <span class="visually-hidden">Loading...</span>
</div></div>`);let t=$(this).attr("data-url"),d=$(this).closest("tr"),a=$(d).children().first().text();$.ajax({type:"POST",url:t,data:{_token:$('meta[name="csrf-token"]').attr("content"),id_order:a},success:function(r){let o="",p=$(".modal-body").attr("data-product-url");for(let e of r)o+="<div id='p-"+e.id+"' style='height: 120px; background: cornsilk!important;' class='card d-block mb-3'><img class='float-start d-block me-2 img-product-order' width='150px' height='120px' src='"+$("#product-body").attr("data-img")+"/products/"+e.id+"/"+e.images[0].image+"'><div class='d-block'><a href='"+p+"/"+e.id+"' class='mt-1 fw-bold text-decoration-none text-dark d-block'>"+e.name+" "+e.count_substance+"</a><hr class='mt-2 mb-1'><span class='d-block fw-bold'><span class='text-warning'>Кількість:</span> "+e.count+" шт</span><span class='d-block fw-bold'><span class='text-warning'>Ціна:</span> "+e.price+" грн</span></div></div>";$(".modal-body").html(o),$(".modal-body").attr("data-order",a)}})}),$("#add-category-plus").click(function(c){$(".add-category-block").css("display")=="none"?($(".add-category-block").css("display","block"),$("#add-name-category-input").val(""),$("#category-keywords").val(""),$("#add-image-category-input").val("")):$(".add-category-block").css("display","none")}),$("#add-product-plus").click(function(c){$(".add-product-block").css("display")=="none"?($(".add-product-block").css("display","block"),$("#add-product-name").val(""),$("#add-product-description").val(""),$("#add-product-count").val(""),$("#add-product-price").val(""),$("#product-keywords").val(""),$("#add-product-image").val("")):$(".add-product-block").css("display","none")}),$("#add-category-btn").click(function(c){let t=new FormData,d=$("#add-name-category-input").val(),a=$("#isActiveCategory").prop("checked"),r=$("#category-keywords").val(),o=$("#add-image-category-input").prop("files")[0],p=$("#add-category-btn").attr("data-url");t.append("_token",$('meta[name="csrf-token"]').attr("content")),t.append("category_name",d),t.append("category_keywords",r),t.append("category_active",a),t.append("category_image",o),$.ajax({type:"POST",enctype:"multipart/form-data",url:p,processData:!1,contentType:!1,data:t,success:function(e){$("#add-category-footer").prepend("<div id='c-"+e.id+"' class='card text-white bg-primary p-2 mb-1 pointer'>"+e.name+"</div>"),$(".category-loader").html(""),$(".add-category-block").css("display","none")}})}),$("#add-product-btn").click(function(c){let t=new FormData,d=$("#add-product-name").val(),a=$("#productDescription").html(),r=$("#add-product-count").val(),o=$("#add-product-count2").val(),p=$("#add-product-count3").val(),e=$("#add-product-count4").val(),l=$("#add-product-price").val(),i=$("#add-product-price2").val(),s=$("#add-product-price3").val(),u=$("#add-product-price4").val(),g=$("#is-active-product").prop("checked"),y=$("#add-product-category").val(),m=$("#product-keywords").val(),v=$("#add-product-image").prop("files"),b=$("#add-product-btn").attr("data-url");t.append("_token",$('meta[name="csrf-token"]').attr("content")),t.append("product_name",d),t.append("product_description",a),t.append("product_count",r),t.append("product_count2",o),t.append("product_count3",p),t.append("product_count4",e),t.append("product_price",l),t.append("product_price2",i),t.append("product_price3",s),t.append("product_price4",u),t.append("product_active",g),t.append("product_category_id",y),t.append("product_keywords",m);for(let n of v)t.append("product_images[]",n);$.ajax({type:"POST",enctype:"multipart/form-data",url:b,processData:!1,contentType:!1,data:t,success:function(n){$("#add-product-footer").prepend("<div id='p-"+n.id+"' class='card text-white bg-warning p-2 mb-1 pointer'>"+n.name+"</div>"),$(".product-loader").html(""),$(".add-product-block").css("display","none")}})}),$(function(){$(".poshtaPopover").popover({placement:"right",trigger:"click"}),$(".tooltipPromo").tooltip({placement:"right",trigger:"hover"})})});
