const sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
const sizesReadable = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
const kibiMultiplier = 1024

function filesToArray (files) {
  return files.size ? [files] : Array.from(files)
}

export function formatBytes (bytes, dm = 2) {
  if (bytes === 0) {
    return '0' + sizesReadable[0]
  }
  const i = Math.floor(Math.log(bytes) / Math.log(kibiMultiplier))

  return parseFloat((bytes / Math.pow(kibiMultiplier, i)).toFixed(dm)) + ' ' + sizesReadable[i]
}

export function haveNormalTotalSize (files, maxSize) {
  const filesArr = filesToArray(files)
  let sum = 0

  for (let file of filesArr) {
    sum += file.size
  }

  if (sum > maxSize) {
    return {
      msg: `!!!Файлы имею слишком большой размер: ${formatBytes(sum)}, макс. размер: ${formatBytes(maxSize)}`,
      ok: false,
      sum
    }
  }

  return {
    ok: true,
    sum
  }
}

export function haveNormalSize (files, maxSize) {
  const filesArr = filesToArray(files)
  let errorFiles = []
  let errorFilesNames = []
  let ok = true

  for (let file of filesArr) {
    if (file.size > maxSize) {
      ok = false
      errorFiles.push(file)
      errorFilesNames.push(file.name)
    }
  }

  if (!ok) {
    let msg

    if (errorFilesNames.length > 1) {
      msg = `!!!Файлы ${errorFilesNames.join(', ')} имеют размер больше нормы(${formatBytes(maxSize)})`
    } else {
      msg = `!!!Файл ${errorFilesNames} имеет размер больше нормы(${formatBytes(maxSize)})`
    }

    return {
      msg,
      ok,
      errorFiles
    }
  }

  return { ok }
}

export function sizeStrToBytesConvert (value) {
  const number = parseInt(value)
  const numberLength = (number).toString().length
  const size = value.slice(numberLength)

  return sizeConvert(number, size, 'B')
}

export function sizeConvert (value, sourceUnit, destinationUnit) {
  const sourceIndex = (sizes.indexOf(sourceUnit))
  const destinationIndex = (sizes.indexOf(destinationUnit))

  let result = value
  let exponent = 0
  if (sourceIndex > destinationIndex) {
    exponent = sourceIndex - destinationIndex
    result = value * Math.pow(kibiMultiplier, exponent)
    return parseFloat(result)
  } else if (sourceIndex < destinationIndex) {
    exponent = destinationIndex - sourceIndex
    result = value / Math.pow(kibiMultiplier, exponent)
    return parseFloat(result)
  } else {
    return result
  }
}
