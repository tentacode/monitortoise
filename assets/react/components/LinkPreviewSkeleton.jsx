import React from "react";

export default function LinkPreviewSkeleton() {
  return (
    <>
      <div className="animate-pulse max-w-sm bg-white border rounded-lg">
        <div className="h-32 bg-lime-200 rounded-t-lg"></div>
        <div className="p-4">
          <div className="h-2 w-20 bg-lime-200 rounded col-span-2"></div>
          <div className="mt-4 h-2 w-20 bg-lime-200 rounded col-span-2"></div>
        </div>
      </div>
    </>
  );
}
