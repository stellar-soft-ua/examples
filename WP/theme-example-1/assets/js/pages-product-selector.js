function copyToClipboard(t){var e=document.createElement("input");e.setAttribute("value",t),document.body.appendChild(e),e.select(),document.execCommand("copy"),document.body.removeChild(e)}!function(t){t(document).ready(function(){t(".pages-product-selector").change(function(e){var o=t(".pages-product-selector").find(":selected").val();jQuery.ajax({type:"POST",url:"/wp-admin/admin-ajax.php",data:{action:"search-products-for-selector",selected_post_type:o},success:function(e){t(".list-container").html(e)}})}),t(document).on("click",".list-item",function(e){e.preventDefault(),t(".list-item").removeClass("selected"),t(this).addClass("selected");var o=t(this).data("post-id"),c=t(this).text();copyToClipboard(o),t(".list-item").each(function(e){var o=t(this).text();-1!==(e=o.indexOf("(Product-ID:"))&&t(this).text(o.substring(0,e))}),-1===c.indexOf("was copied to clipboard")&&t(this).text(c+" (Product-ID:"+o+" was copied to clipboard!)")})})}(jQuery);