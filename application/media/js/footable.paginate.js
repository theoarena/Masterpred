(function(g,h,n){function p(c){var a=g(c.table).data();this.pageNavigation=a.pageNavigation||c.options.pageNavigation;this.pageSize=a.pageSize||c.options.pageSize;this.firstText=a.firstText||c.options.firstText;this.previousText=a.previousText||c.options.previousText;this.nextText=a.nextText||c.options.nextText;this.lastText=a.lastText||c.options.lastText;this.limitNavigation=parseInt(a.limitNavigation||c.options.limitNavigation||m.limitNavigation,10);this.limitPreviousText=a.limitPreviousText||c.options.limitPreviousText; this.limitNextText=a.limitNextText||c.options.limitNextText;this.limit=0<this.limitNavigation;this.currentPage=0;this.pages=[];this.control=!1}if(h.footable===n||null===h.footable)throw Error("Please check and make sure footable.js is included in the page and is loaded prior to this script.");var m={paginate:!0,pageSize:10,pageNavigation:".pagination",firstText:"&laquo;",previousText:"&lsaquo;",nextText:"&rsaquo;",lastText:"&raquo;",limitNavigation:0,limitPreviousText:"...",limitNextText:"..."};h.footable.plugins.register(function(){var c= this;c.name="Footable Paginate";c.init=function(a){!0===a.options.paginate&&!1!==g(a.table).data("page")&&(c.footable=a,g(a.table).unbind(".paging").bind({"footable_initialized.paging footable_row_removed.paging footable_redrawn.paging footable_sorted.paging footable_filtered.paging":function(){c.setupPaging()}}).data("footable-paging",c))};c.setupPaging=function(){var a=c.footable,e=g(a.table).find("> tbody");a.pageInfo=new p(a);c.createPages(a,e);c.createNavigation(a,e);c.fillPage(a,e,a.pageInfo.currentPage)}; c.createPages=function(a,c){var b=1,d=a.pageInfo,f=b*d.pageSize,k=[],h=[];d.pages=[];var l=c.find("> tr:not(.footable-filtered,.footable-row-detail)");l.each(function(a,c){k.push(c);a===f-1?(d.pages.push(k),b++,f=b*d.pageSize,k=[]):a>=l.length-l.length%d.pageSize&&h.push(c)});0<h.length&&d.pages.push(h);d.currentPage>=d.pages.length&&(d.currentPage=d.pages.length-1);0>d.currentPage&&(d.currentPage=0);1===d.pages.length?g(a.table).addClass("no-paging"):g(a.table).removeClass("no-paging")};c.createNavigation= function(a,e){var b=g(a.table).find(a.pageInfo.pageNavigation);if(0===b.length){b=g(a.pageInfo.pageNavigation);if(0<b.parents("table:first").length&&b.parents("table:first")!==g(a.table))return;1<b.length&&!0===a.options.debug&&console.error("More than one pagination control was found!")}if(0!==b.length){b.is("ul")||(0===b.find("ul:first").length&&b.append("<ul />"),b=b.find("ul"));b.find("li").remove();var d=a.pageInfo;d.control=b;0<d.pages.length&&(b.append('<li class="footable-page-arrow"><a data-page="first" href="#first">'+ a.pageInfo.firstText+"</a>"),b.append('<li class="footable-page-arrow"><a data-page="prev" href="#prev">'+a.pageInfo.previousText+"</a></li>"),d.limit&&b.append('<li class="footable-page-arrow"><a data-page="limit-prev" href="#limit-prev">'+a.pageInfo.limitPreviousText+"</a></li>"),d.limit||g.each(d.pages,function(a,d){0<d.length&&b.append('<li class="footable-page"><a data-page="'+a+'" href="#">'+(a+1)+"</a></li>")}),d.limit&&(b.append('<li class="footable-page-arrow"><a data-page="limit-next" href="#limit-next">'+ a.pageInfo.limitNextText+"</a></li>"),c.createLimited(b,d,0)),b.append('<li class="footable-page-arrow"><a data-page="next" href="#next">'+a.pageInfo.nextText+"</a></li>"),b.append('<li class="footable-page-arrow"><a data-page="last" href="#last">'+a.pageInfo.lastText+"</a></li>"));b.off("click","a[data-page]").on("click","a[data-page]",function(f){f.preventDefault();var e=g(this).data("page");f=d.currentPage;"first"===e?f=0:"prev"===e?0<f&&f--:"next"===e?f<d.pages.length-1&&f++:"last"===e?f=d.pages.length- 1:"limit-prev"===e?(f=-1,e=b.find(".footable-page:first a").data("page"),c.createLimited(b,d,e-d.limitNavigation),c.setPagingClasses(b,d.currentPage,d.pages.length)):"limit-next"===e?(f=-1,e=b.find(".footable-page:last a").data("page"),c.createLimited(b,d,e+1),c.setPagingClasses(b,d.currentPage,d.pages.length)):f=e;if(0<=f){if(d.limit&&d.currentPage!=f){for(e=f;0!==e%d.limitNavigation;)e-=1;c.createLimited(b,d,e)}c.paginate(a,f)}});c.setPagingClasses(b,d.currentPage,d.pages.length)}};c.createLimited= function(a,c,b){b=b||0;a.find("li.footable-page").remove();var d,f=a.find('li.footable-page-arrow > a[data-page="limit-prev"]').parent(),g=a.find('li.footable-page-arrow > a[data-page="limit-next"]').parent();for(a=c.pages.length-1;0<=a;a--)d=c.pages[a],a>=b&&a<b+c.limitNavigation&&0<d.length&&f.after('<li class="footable-page"><a data-page="'+a+'" href="#">'+(a+1)+"</a></li>");0===b?f.hide():f.show();b+c.limitNavigation>=c.pages.length?g.hide():g.show()};c.paginate=function(a,e){var b=a.pageInfo; if(b.currentPage!==e){var d=g(a.table).find("> tbody"),f=a.raise("footable_paging",{page:e,size:b.pageSize});f&&!1===f.result||(c.fillPage(a,d,e),b.control.find("li").removeClass("active disabled"),c.setPagingClasses(b.control,b.currentPage,b.pages.length))}};c.setPagingClasses=function(a,c,b){a.find("li.footable-page > a[data-page="+c+"]").parent().addClass("active");c>=b-1&&(a.find('li.footable-page-arrow > a[data-page="next"]').parent().addClass("disabled"),a.find('li.footable-page-arrow > a[data-page="last"]').parent().addClass("disabled")); 1>c&&(a.find('li.footable-page-arrow > a[data-page="first"]').parent().addClass("disabled"),a.find('li.footable-page-arrow > a[data-page="prev"]').parent().addClass("disabled"))};c.fillPage=function(a,e,b){a.pageInfo.currentPage=b;e.find("> tr").hide();g(a.pageInfo.pages[b]).each(function(){c.showRow(this,a)})};c.showRow=function(a,c){var b=g(a),d=b.next();g(c.table).hasClass("breakpoint")&&b.hasClass("footable-detail-show")&&d.hasClass("footable-row-detail")?(b.add(d).show(),c.createOrUpdateDetailRow(a)): b.show()}},m)})(jQuery,window);