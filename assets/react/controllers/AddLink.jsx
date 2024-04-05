import React, { useEffect } from "react";
import { useState } from "react";

import { LinkIcon } from "@heroicons/react/20/solid";
import LinkPreview from "../components/LinkPreview";
import { DebounceInput } from "react-debounce-input";

export default function AddLink() {
  const testLinks = [
    "https://tentacode.dev/ma-mission-ideale",
    "https://www.youtube.com/watch?v=hTuPwVYHc_M",
    "https://github.com/tentacode",
    "https://www.nngroup.com/articles/mobile-input-checklist/",
  ];

  const [testLinkIndex, setTestLinkIndex] = useState(0);
  const [linkUrl, setLinkUrl] = useState("");
  // const [link, setLink] = useState({
  //   title: "\ud83d\udc96 Ma mission id\u00e9ale \ud83d\udc96",
  //   description:
  //     "Bonjour \u00e0 vous et merci de l\u0027int\u00e9r\u00eat que vous portez \u00e0 mon profil ! J\u0027ai \u00e9crit cette petite lettre \u00e0 l\u0027attention des recruteur\u2022euses pour pr\u00e9senter un peu plus en d\u00e9tail quel genre de\u2026",
  //   imageUrl: "https://tentacode.dev/img/posts/alecoutedumarche.jpg",
  // });
  const [link, setLink] = useState(null);
  const [loading, setLoading] = useState(false);

  function handleInputChange(e) {
    const url = e.target.value;
    setLinkUrl(url);

    if (url === "") {
      setLink(null);
      return;
    }

    setLoading(true);

    // call the /api/link/preview endpoint with fetch and a url query string
    fetch(`/api/link/preview?url=${url}`)
      .then((response) => response.json())
      .then((data) => {
        setLink(data);
        setLoading(false);
      });
  }

  return (
    <>
      <div className="relative rounded-md">
        <div className="relative">
          <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <LinkIcon className="h-5 w-5 text-gray-400" aria-hidden="true" />
          </div>
          <DebounceInput
            value={linkUrl}
            onChange={handleInputChange}
            debounceTimeout={300}
            type="text"
            name="add_link"
            id="add_link"
            data-testid="add_link_input"
            className="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-lime-400 sm:text-sm sm:leading-6"
            placeholder="https://believe-in-your-dreams.com"
          />
        </div>
      </div>

      <button
        onClick={() => {
          const newLinkUrl = testLinks[testLinkIndex];

          setLinkUrl(newLinkUrl);
          setTestLinkIndex((testLinkIndex + 1) % testLinks.length);
          const event = {
            target: { value: newLinkUrl },
          };
          handleInputChange(event);
        }}
        className="mt-4 hover:bg-slate-200  bg-slate-100 text-black font-bold py-2 px-4 rounded"
      >
        Test Links
      </button>

      <div className="mt-4">
        <LinkPreview link={link} loading={loading} />
      </div>
    </>
  );
}
