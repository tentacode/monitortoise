import React from "react";

export default function LinkPreviewSkeleton() {
  return (
    <div className="animate-pulse flex w-full items-center justify-between p-6">
      <div className="flex-1 truncate">
        <div className="flex items-center">
          <div class="h-2 w-20 bg-lime-200 rounded col-span-2"></div>
        </div>
        <div class="mt-4 h-2 w-20 bg-lime-200 rounded col-span-2"></div>
      </div>

      <div class="h-10 w-10 flex-shrink-0 bg-lime-200 rounded-full"></div>
    </div>
  );
}
