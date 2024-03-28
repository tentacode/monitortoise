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
    <div className="flex w-full items-top justify-between p-6">
      <div className="flex-1">
        <div className="flex items-center">
          <h3 className="truncate text-sm font-medium text-gray-900">
            {link.title}
          </h3>
          {/* <span className="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
          {person.role}
        </span> */}
        </div>
        <p className="mt-1 text-sm text-gray-500">{link.description}</p>
      </div>
      <img
        className="h-10 w-10 flex-shrink-0 rounded-full bg-gray-300"
        src={link.imageUrl}
        alt=""
      />
    </div>
  );
}
