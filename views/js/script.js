const tries = Array.from(document.querySelectorAll('input[name="trie"]'));
let url = window.location.href;
let urlSearchParams = new URLSearchParams(url);
let trie = "";
let newUrl = "";
tries.forEach((element) => {
  element.addEventListener("change", () => {
    if (element.checked) {
      trie = tries.find((element) => element.checked).value;
      if (urlSearchParams.has("trie")) {
        urlSearchParams.set("trie", trie);

        const decodedUrl = urlSearchParams
          .toString()
          .split("&")
          .map((param) => {
            const [key, value] = param.split("=");
            return `${decodeURIComponent(key)}=${decodeURIComponent(value)}`;
          })
          .join("&");

        window.location.href = decodedUrl;
      } else {
        newUrl =
          url + "&trie=" + tries.find((element) => element.checked).value;
        window.location.href = newUrl;
      }
    }
  });
  if (urlSearchParams.has("trie")) {
    if (urlSearchParams.get("trie") == element.value) {
      element.checked = true;
    } else {
      element.checked = false;
    }
  } else {
    if (element.value == "nom_formation") {
      element.checked = true;
    }
  }
});
