import React from "react";
import LinkPreviewSkeleton from "./LinkPreviewSkeleton";

export default function LinkPreview({ link, loading }) {
  if (link === null) {
    return;
  }

  if (loading) {
    return <LinkPreviewSkeleton />;
  }

  return (
    <div className="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
      <a href="#">
        <img className="rounded-t-lg" src={link.imageUrl} alt="" />
      </a>
      <div className="p-4">
        <a href="#">
          <h5 className="mb-2 text-xl font-bold tracking-tight text-gray-900">
            {link.title}
          </h5>
        </a>
        <p className="mb-3 text-sm font-normal text-gray-700">
          {link.description}
        </p>
      </div>
    </div>
  );
}
