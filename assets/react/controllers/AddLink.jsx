import React from "react";
import { useState } from "react";

import { LinkIcon } from "@heroicons/react/20/solid";
import LinkPreview from "../components/LinkPreview";

export default function AddLink() {
  const testLinks = [
    'https://tentacode.dev',
    'https://www.youtube.com/watch?v=hTuPwVYHc_M',
    'https://github.com/tentacode',
    'https://www.nngroup.com/articles/mobile-input-checklist/',
  ];

  const [testLinkIndex, setTestLinkIndex] = useState(0);
  const [linkUrl, setLinkUrl] = useState('');
  const [link, setLink] = useState(null);
  const [loading, setLoading] = useState(false);

  function handleInputChange(e) {
    const url = e.target.value;

    if (url === "") {
      setLink(null);
      return;
    }

    setLoading(true);

    setTimeout(() => {
      setLoading(false);
    }, 500);

    setLink({
      title: "tentacode.dev",
      description:
        "A website that will help you to believe in your dreams that will help you to believe in your dreams that will help you to believe in your dreams that will help you to believe in your dreams that will help you to believe in your dreams",
      imageUrl: "https://tentacode.dev/favicon.ico",
    });

    console.log("handleInptChange", url);
  }

  return (
    <>
      <div className="col-span-1 rounded-lg bg-white shadow">
        <LinkPreview link={link} loading={loading} />
        <div>
          <div className="relative p-3 rounded-md shadow-sm">
            <div className="relative">
              <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <LinkIcon
                  className="h-5 w-5 text-gray-400"
                  aria-hidden="true"
                />
              </div>
              <input
                value={linkUrl}
                onChange={handleInputChange}
                type="text"
                name="add_link"
                id="add_link"
                className="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-lime-400 sm:text-sm sm:leading-6"
                placeholder="https://believe-in-your-dreams.com"
              />
            </div>
          </div>
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
        className="mt-5 bg-lime-500 hover:bg-lime-600 text-white font-bold py-2 px-4 rounded">
        Test Links
      </button>
    </>
  );
}
